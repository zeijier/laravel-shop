<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UsersController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        //Admin::content()会根据回调函数来渲染页面，它会自动渲染页面顶部、菜单、底部等公共元素，
        //而我们可以调用 $content 的方法在页面上添加元素来设置不同页面的内容。
        return Admin::content(function (Content $content) {
//          页面标题
            $content->header('用户列表');
            $content->body($this->grid());
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        // 根据回调函数，在页面上用表格的形式展示用户记录
        return Admin::grid(User::class, function (Grid $grid) {
            //创建一个列名为 ID 的列，内容是用户的 id 字段，并且可以在前端页面点击排序
            $grid->id('ID')->sortable();
            // 创建一个列名为 用户名 的列，内容是用户的 name 字段。下面的 email() 和 created_at() 同理
            $grid->name('用户名');
            $grid->email('邮箱');
            $grid->email_verified('已验证邮箱')->dispaly(function($value){
                return $value?'是':'否';
            });
            //后台禁用'新建'按钮，
            $grid->disableCreateButton();
            $grid->actions(function ($actions){
                // 不在每一行后面展示查看按钮
                $actions->disableView();
                // 不在每一行后面展示删除按钮
                $actions->disableDelete();
                // 不在每一行后面展示编辑按钮
                $actions->disableEdit();
            });
            $grid->created_at('注册时间');
            $grid->tools(function ($tools){
                //禁用批量删除按钮
                $tools->batch(function ($batch){
                   $batch->disableDelete();
                });
            });
        });
    }

}
