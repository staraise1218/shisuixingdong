<?php


namespace app\common\library\payment\wxpay;

use think\Db;
use think\Log;
use think\Image;

/**
*
* example目录下为简单的支付样例，仅能用于搭建快速体验微信支付使用
* 样例的作用仅限于指导如何使用sdk，在安全上面仅做了简单处理， 复制使用样例代码时请慎重
* 请勿直接直接使用样例对外提供服务
* 
**/

require_once ( EXTEND_PATH . 'wxpay/WxPay.Api.php');
require_once ( EXTEND_PATH . 'wxpay/WxPay.Notify.php');



class Notify extends \WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);

		$config = new WxPayConfig();
		$result = WxPayApi::orderQuery($config, $input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}

	//重写回调处理函数
	/**
	 * @param WxPayNotifyResults $data 回调解释出的参数
	 * @param WxPayConfigInterface $config
	 * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
	 * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
	 */
	public function NotifyProcess($objData, $config, &$msg)
	{
		$data = $objData->GetValues();
		//TODO 1、进行参数校验
		if(!array_key_exists("return_code", $data) 
			||(array_key_exists("return_code", $data) && $data['return_code'] != "SUCCESS")) {
			//TODO失败,不是支付成功的通知
			//如果有需要可以做失败时候的一些清理处理，并且做一些监控
			$msg = "异常异常";
			return false;
		}
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}

		//TODO 2、进行签名验证
		try {
			$checkResult = $objData->CheckSign($config);
			if($checkResult == false){
				//签名错误
				$msg = '签名错误';
				return false;
			}
		} catch(Exception $e) {
			
		}

		//TODO 3、处理业务逻辑
		$order_sn = substr($data['out_trade_no'], 0, 18);

		$donation = Db::name('donation')->where('order_sn', $order_sn)->find();
        // 检测订单状态
        if($donation['paystatus'] == 1) {
            echo 'success';
            return false;
        }
        // 更新学生捐助状态,及捐助人，捐助订单id
        $updatedata = array(
            'paystatus' => 1,
            'paytime' => time(),
            'payment_method' => '1',
            'expirytime' => strtotime('+1 year'),
        );
        // 更新订单表
        Db::name('donation')->where('order_sn', $order_sn)->update($updatedata);
        

        $updateStudentData = array(
            'donation_status' => 2,
            'donor' => $donation['user_id'],
            'donation_id' => $donation['id'],
        );
        Db::name('student')->where('id', $donation['student_id'])->update($updateStudentData);
        // 添加善款追踪记录
        Db::name('track')->insert(array(
            'student_id'=>$donation['student_id'],
            'title' => '捐款提醒',
            'content' => '捐款成功',
            'donor' => $donation['user_id'],
            'donation_id' => $donation['id'],
            'createtime' => time(),
        ));

        // 生成证书
        $filepath = 'certificate/'.str_pad($donation['user_id'], 6, '0', STR_PAD_LEFT).'/';
        if( ! is_dir($filepath)){
            mkdir($filepath, 0777, true);
        }
        $filename = $filepath.md5(time()).'.jpg';
        $Image = Image::open('static/images/certificate_template.jpg');
        // 给原图左上角添加水印并保存water_image.png
        $Image->text($donation['fullname'], 'static/font/YaHei.ttf', 96, '#000000', Image::WATER_CENTER, array(0, -390))
        ->text(date('Y'), 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(-160, 925))
        ->text(date('m'), 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(-35, 925))
        ->text(date('d'), 'static/font/YaHei.ttf', 24, '#000000', Image::WATER_CENTER, array(70, 925))
            ->save($filename);
        Db::name('certificate')->insert(array(
            'user_id' => $donation['user_id'],
            'image' => '/'.$filename,
            'createtime' => time(),
        ));
            
		Log::info($data);
		
		
		
		return true;
	}
}