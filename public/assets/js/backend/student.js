define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'student/index',
                    add_url: 'student/add',
                    edit_url: 'student/edit',
                    del_url: 'student/del',
                    multi_url: 'student/multi',
                    table: 'student',
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
                        {field: 'name', title: __('Name')},
                        {field: 'nation', title: __('Nation')},
                        {field: 'age', title: __('Age')},
                        {field: 'sexdata', title: __('Sexdata'), visible:false, searchList: {"1":__('Sexdata 1'),"2":__('Sexdata 2')}},
                        {field: 'sexdata_text', title: __('Sexdata'), operate:false},
                        {field: 'number', title: __('Number')},
                        {field: 'school.name', title: __('School_id')},
                        // {field: 'family_status', title: __('Family_status'), formatter: Table.api.formatter.status},
                        // {field: 'city', title: __('City')},
                        {field: 'needmoney', title: __('Needmoney'), operate:'BETWEEN'},
                        {field: 'needyear', title: __('Needyear')},
                        {field: 'donation_status', title: __('Donation_status'), visible:false, searchList: {"1":__('Donation_status 1'),"2":__('Donation_status 2')}},
                        {field: 'donation_status_text', title: __('Donation_status'), operate:false},
                        {field: 'status', title: __('Status'), visible:false, searchList: {"1":__('Status 1'),"2":__('Status 2')}},
                        {field: 'status_text', title: __('Status'), operate:false},
                        // {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, buttons: [
                                {name: 'situation', text: '学生近况', title: '学生近况', icon: 'fa fa-list', classname: 'btn btn-xs btn-primary', url: 'Studentsituation/index'}
                                ], events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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