define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            var activity_id = $('input[name=activity_id]').val();
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'activityenroll/index?activity_id='+activity_id,
                    add_url: 'activityenroll/add',
                    edit_url: 'activityenroll/edit',
                    del_url: 'activityenroll/del',
                    multi_url: 'activityenroll/multi',
                    table: 'activity_enroll',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        // {field: 'activity_id', title: __('Activity_id')},
                        {field: 'user_id', visible:false, title: __('User_id')},
                        {field: 'fullname', title: __('Fullname')},
                        {field: 'mobile', title: __('Mobile')},
                        {field: 'email', title: __('Email')},
                        {field: 'sex', title: __('Sex'), visible:false, searchList: {"0":__('Sex 0'),"1":__('Sex 1')}},
                        {field: 'sex_text', title: __('Sex'), operate:false},
                        {field: 'ID_no', title: __('Id_no')},
                        {field: 'fang', title: __('Fang')},
                        {field: 'people_num', title: __('People_num'), visible:false, searchList: {"2":__('People_num 2')}},
                        {field: 'people_num_text', title: __('People_num'), operate:false},
                        {field: 'createtime', title: '报名时间', operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});