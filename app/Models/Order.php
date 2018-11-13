<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    //定义订单退款的各个状态
    const REFUND_STATUS_PENDING = 'pending';
    const REFUND_STATUS_APPLIED = 'applied';
    const REFUND_STATUS_PROCESSING = 'processing';
    const REFUND_STATUS_SUCCESS = 'success';
    const REFUND_STATUS_FAILED = 'failed';
    //定义订单物流的各个状态
    const SHIP_STATUS_PENDING = 'pending';
    const SHIP_STATUS_DELIVERED = 'delivered';
    const SHIP_STATUS_RECEIVED = 'received';

    //静态数组将上面的常量联系起来
    public static $refundStatusMap = [
        self::REFUND_STATUS_PENDING    => '未退款',
        self::REFUND_STATUS_APPLIED    => '已申请退款',
        self::REFUND_STATUS_PROCESSING => '退款中',
        self::REFUND_STATUS_SUCCESS    => '退款成功',
        self::REFUND_STATUS_FAILED     => '退款失败',
    ];

    public static $shipStatusMap = [
        self::SHIP_STATUS_PENDING   => '未发货',
        self::SHIP_STATUS_DELIVERED => '已发货',
        self::SHIP_STATUS_RECEIVED  => '已收货',
    ];

    protected $fillable = [
        'no',
        'address',
        'total_amount',
        'remark',
        'paid_at',
        'payment_method',
        'payment_no',
        'refund_status',
        'refund_no',
        'closed',
        'reviewed',
        'ship_status',
        'ship_data',
        'extra',
    ];

    protected $casts = [
      'closed'=>'boolean',
      'reviewed'=>'boolean',
      'address'=>'json',
      'ship_data'=>'json',
      'extra'=>'json',
    ];

    protected $dates = [
      'paid_at'
    ];

    //注册一个模型创建事件监听，用于自动生成订单流水号
    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        // 监听模型创建事件，在写入数据库之前触发
        static::creating(function($model){
            // 如果模型的 no 字段为空
            if (!$model->no){
        // 调用 findAvailableNo 生成订单流水号
                $model->no = static::findAvailableNo();
                if (!$model->no){
                    return false;
                }
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
    public static function findAvailableNo(){
        //订单号流水号前缀
        $prefix = data('YmdHis');
        for ($i=0;$i<10;++$i){
            //随机生成6位的数字，填充字符串变成6位。
            $no = $prefix.str_pad(random_int(0,999999),6,'0',STR_PAD_LEFT);
            //先查数据库，看是否存在订单
            if (!self::query()->where('no',$no)->exists()){
                return $no;
            }
        }
        Log::warning('find order so failed');
        return false;
    }
}
