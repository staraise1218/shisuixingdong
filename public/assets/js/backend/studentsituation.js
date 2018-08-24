define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {

        var student_id = $('input[name=student_id]').val();

            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'studentsituation/index?student_id='+student_id,
                    add_url: 'studentsituation/add?student_id='+student_id,
                    edit_url: 'studentsituation/edit',
                    del_url: 'studentsituation/del',
                    multi_url: 'studentsituation/multi',
                    table: 'student_situation',
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
                        {field: 'id', title: __('Id'), searchable: false},
                        {field: 'student.name', title: __('Student_id'), searchable: false},
                        {field: 'title', title: __('Title'), operate:'LIKE'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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