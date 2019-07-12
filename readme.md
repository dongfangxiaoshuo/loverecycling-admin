## 爱回收(后端)

> 环境及框架

###### laravel5.8.17+php7.3.1+Mysql5.7.24+Apache2.4.37

> 业务系统

![Image text](./public/img/业务系统.png)

#### 订单模块

1. 订单内容信息

![Image text](./public/img/订单内容信息.jpg)

2. 流程引擎

（1）正向流程

以一个通用B2C商城的订单系统为例，根据其实际业务场景，其订单流程可抽象为5大步骤：订单创建>订单支付>订单生产>订单确认>订单完成。

![Image text](./public/img/核心流程.jpg)

（2）逆向流程

逆向流程是各种修改订单、取消订单、退款、退货等操作，需要梳理清楚这些流程与正向流程的关系，才能理清订单系统完整的订单流程。

![Image text](./public/img/逆向流程.jpg)

（3）状态机

状态机是管理订单状态逻辑的工具。状态机可归纳为3个要素，即现态、动作、次态。

现态：是指当前所处的状态。

动作：动作执行完毕后，可以迁移到新的状态，也可以仍旧保持原状态。

次态：动作满足后要迁往的新状态，“次态”是相对于“现态”而言的，“次态”一旦被激活，就转变成新的“现态”了。

![Image text](./public/img/订单流程状态.jpg)

> 数据库设计

#### 公用模块

###### 售出商品信息表(Sell_Good)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(sell_good_id) | INT | Yes | 0 | Yes | 售出商品主键
product__information_id | INT | Yes | 0 | No | 产品信息(关联产品信息外键)
promotion_information_id | INT | Yes | 0 | No | 售出商品促销信息(关联促销信息外键)
sell_good_price | INT | Yes | 0 | No | 售出商品价格
created_at | TIMESTAMP | Yes | 实时时间 | No | 创建时间
updated_at | TIMESTAMP | Yes | 实时时间 | No | 更新时间


###### 回收商品信息表(Recovery_Good)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(recovery_good_id) | INT | Yes | 0 | Yes | 回收商品主键
product__information_id | INT | Yes | 0 | No | 产品信息(关联产品信息外键)
promotion_information_id | INT | Yes | 0 | No | 回收商品促销信息(关联促销信息外键)
recovery_good_price | INT | Yes | 0 | No | 回收商品价格
created_at | TIMESTAMP | Yes | 实时时间 | No | 创建时间
updated_at | TIMESTAMP | Yes | 实时时间 | No | 更新时间

###### 广告信息表(Banner)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(banner_id) | INT | Yes | 0 | Yes | 广告信息主键
imgUrl | VARCHAR | Yes | 0 | No | 广告信息图片链接
toUrl | VARCHAR | Yes | 0 | No | 广告跳转链接
created_at | TIMESTAMP | Yes | 实时时间 | No | 创建时间
updated_at | TIMESTAMP | Yes | 实时时间 | No | 更新时间

#### 首页模块
###### 首页广告表(Index_Information)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(index_information_id) | INT | Yes | 0 | Yes | 首页广告主键
banner_id(promotion__id) | INT | Yes| 0 | No | 首页广告图(外键关联促销信息表)
active_id(promotion__id) | INT | Yes | 0 | No | 倒计时秒杀(外键关联促销信息表)
recovery_good_id | INT | Yes | 0 | No |旧机回收(关联回收商品表外键)
sell_good__id | INT | Yes | 0 | No |新机原价(关联售出商品表外键)
more  | INT | Yes | 0 | No |更多火爆信息(可以放多个逗号分隔,关联售出商品表外键)
hot_acitve | INT | Yes | 0 | No |热门活动(可以放多个逗号分隔,关联促销信息表外键)
public_welfare | INT | Yes | 0 | No |公益(可以放多个逗号分隔,广告信息表外键)
cooperative_partner_imgUrl | VARCHAR | Yes | 0 | No |合作伙伴图片链接
created_at | TIMESTAMP | Yes | 实时时间 | No | 创建时间
updated_at | TIMESTAMP | Yes | 实时时间 | No | 更新时间

###### 首页功能分类表(Index_Type)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(active) | INT | Yes | 0 | Yes | 首页功能分类主键
name | VARCHAR | Yes | 0 | No | 功能分类名称
banner | INT | Yes | 0 | no | 广告(可以放多个逗号分隔,关联广告信息表外键)
created_at | TIMESTAMP | Yes | 实时时间 | No | 创建时间
updated_at | TIMESTAMP | Yes | 实时时间 | No | 更新时间

###### 首页功能分类详情表(Index_Type_Detail)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(active) | INT | Yes | 0 | Yes | 首页功能分类主键
index_type_id | INT | Yes | 0 | Yes | 判断属于哪个分类(关联首页功能分类表外键)
name | VARCHAR | Yes | 0 | No | 功能分类详细名称
imgURL | VARCHAR | Yes | 0 | No | 功能分类详情图片链接
toUrl | VARCHAR | Yes | 0 | No | 功能分类详情跳转链接
created_at | TIMESTAMP | Yes | 实时时间 | No | 创建时间
updated_at | TIMESTAMP | Yes | 实时时间 | No | 更新时间



#### 订单模块
###### 订单基础信息(Order_Basis_Information)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
order_id | INT | Yes | 0 | Yes | 订单基础信息主键
order_type | ENUM | Yes | 0 | No | 订单类型:[{1:旧机回收(recovery)},{2:以旧换新(renew),{3:维修(repair)}]
order_state | ENUM | Yes | 0 | No | 订单状态:[{1:待付款(obligation)},{2:待发货(delivery),{3:已发货(shipped)},{4:待付款(dealDone)},{5:售后中(afterSale),{6:交易关闭(dealClosure)}]
order_Channel | ENUM | Yes | 0 | No | 订单渠道:[{1:pc},{2:H5,{3:app}]
created_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 创建时间
updated_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 更新时间

###### 用户信息(User_Information)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
user_id | INT | Yes | 0 | Yes | 用户信息主键
member_id | INT | Yes | 0 | No | 用户会员信息外键
logistics_id | INT | Yes | 0 | No | 物流信息外键
created_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 创建时间
updated_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 更新时间

###### 品牌(Brand)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(brand_id) | INT | Yes | 0 | Yes | 品牌主键
brand_name | VARCHAR | Yes | 0 | No | 品牌名称
created_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 创建时间
updated_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 更新时间

###### 产品信息(Product_Information)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
id(product_id) | INT | Yes | 0 | Yes | 产品信息主键
brand_id | INT | Yes | 0 | No | 品牌外键
product_type | ENUM | Yes | 0 | No | 产品类型:[{0:手机},{1:笔记本电脑},{2:平板},{3:摄影摄像},{4:智能数码}]
product_name | VARCHAR | Yes | 0 | No | 产品名称
sku_memory_capacity | ENUM | Yes | 0 | No | SKU内存容量:[{1:2G},{2:3G},{3:4G},{4:6G},{5:8G}]
sku_storage_space | ENUM | Yes | 0 | No | SKU存储空间:[{1:16G},{2:32G},{3:64G},{4:128G},{5:256G}，{6:512G}]
sku_color | VARCHAR | Yes | 0 | No | SKU颜色 
sku_network_type | ENUM | Yes | 0 | No | SKU网络类型:[{1:全网通},{2:联通},{3:移动},{4:电信}]
created_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 创建时间
updated_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 更新时间


###### 物流信息(Logistics_Information)


字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
logistics__id | INT | Yes | 0 | Yes | 物流信息主键
logistics_documetn_number | INT | Yes | 0 | No | 物流单号
logistics_company | VARCHAR | Yes | 0 | No | 物流公司
logistics_state | VARCHAR | Yes | 0 | No | 物流状态
created_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 创建时间
updated_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 更新时间

###### 支付信息(Payment_Information)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
payment__id | INT | Yes | 0 | Yes | 支付信息主键
goods_total | INT | Yes | 0 | No | 商品总金额
freight | INT | Yes | 0 | No | 运费
promotion_money  | INT | Yes | 0 | No | 促销活动金额
coupon_money  | INT | Yes | 0 | No | 优惠券金额
other_coupon | INT | Yes | 0 | No | 其他优惠金额
coupon_total | INT | Yes | 0 | No | 优惠总金额
payment_amount | INT | Yes | 0 | No | 优惠总金额
created_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 创建时间
updated_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 更新时间

###### 促销信息(Promotion_Information)

字段名 | 数据类型 | 不是NULL | 默认值 | 主键 | 注释
---|---|---|---|--- |---
promotion__id | INT | Yes | 0 | Yes | 促销信息主键
promotion_type | ENUM | Yes | 0 | No | 促销类型:[{1:活动(active)},{2:优惠券(coupon),{3:其他优惠(other_coupon)}]
promotion_content | VARCHAR | No | 0 | No | 促销信息内容
end_time | TIMESTAMP | No | 限定时间 | No | 促销结束时间
money | INT | Yes | 0 | No | 促销金额
imgUrl | VARCHAR | Yes | 0 | No | 促销图片链接
created_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 创建时间
updated_at | TIMESTAMP | Yes | 9999-12-31 23:59:59 | No | 更新时间





> Api接口
#### 首页(index)
###### Route::get('/get_index_informations','Home\IndexController@index'); //请求首页数据
#### 类别(category)
###### Route::get('/category','Home\CategoryController@index');  //获取首页加载数据
###### Route::get('/category/productInformation','Home\CategoryController@productInformation');//获取根据产品类型、品牌区分的数据
