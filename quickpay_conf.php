<?php

/*
 * @file    quickpay_service.inc.php
 * @author  fengmin(felix021@gmail.com)
 * @date    2011-08-22
 * @version $Revision$
 *
 */

class quickpay_conf
{

    const VERIFY_HTTPS_CERT = false;

    static $timezone        = "Asia/Shanghai"; //时区
    static $sign_method     = "md5"; //摘要算法，目前仅支持md5 (2011-08-22)

    static $security_key    = "88888888"; //商户密钥

    //支付请求预定义字段
    static $pay_params  = array(
        'version'       => '1.0.0',
        'charset'       => 'UTF-8', //UTF-8, GBK等
        'merId'         => '105550149170027', //商户填写
        'acqCode'       => '',  //收单机构填写
        'merCode'       => '',  //收单机构填写
        'merAbbr'       => '亿家网', //商户代码对应的商户名称。一般出现在显示给持卡人的页面中。一般用于请求消息中，表示商户名称。
    );

    //* 测试环境
    static $front_pay_url   = "http://202.101.25.184/UpopWeb/api/Pay.action";
    static $back_pay_url    = "http://202.101.25.184/UpopWeb/api/BSPay.action";
    static $query_url       = "http://202.101.25.184/UpopWeb/api/Query.action";
    //*/

    /* 预上线环境
    static $front_pay_url   = "https://www.epay.lxdns.com/UpopWeb/api/Pay.action";
    static $back_pay_url    = "https://www.epay.lxdns.com/UpopWeb/api/BSPay.action";
    static $query_url       = "https://www.epay.lxdns.com/UpopWeb/api/Query.action";
    //*/

    /* 线上环境
    static $front_pay_url   = "https://unionpaysecure.com/api/Pay.action";
    static $back_pay_url    = "https://besvr.unionpaysecure.com/api/BSPay.action";
    static $query_url       = "https://query.unionpaysecure.com/api/Query.action";
    //*/
    
    const FRONT_PAY = 1;
    const BACK_PAY  = 2;
    const RESPONSE  = 3;
    const QUERY     = 4;

    const CONSUME                = "01";
    const CONSUME_VOID           = "31";
    const PRE_AUTH               = "02";
    const PRE_AUTH_VOID          = "32";
    const PRE_AUTH_COMPLETE      = "03";
    const PRE_AUTH_VOID_COMPLETE = "33";
    const REFUND                 = "04";
    const REGISTRATION           = "71";

    const CURRENCY_CNY      = "156";

    //支付请求可为空字段（但必须填写）
    static $pay_params_empty = array(
        "origQid"           => "",//原始交易流水号  当交易类型是撤销或者退货时，该域必须出现  其他交易该域不可出现
        "acqCode"           => "", //收单机构代码。该收单机构应是已被批准加入银联互联网系统的，能为商户网站提供收单服务的入网机构。
        "merCode"           => "",//商户类型
        "commodityUrl"      => "", // 商品URL
        "commodityName"     => "",  //商品名称
        "commodityUnitPrice"=> "", //商品单价  单件商品的价格。本域中不带小数点，
        "commodityQuantity" => "",//商品数量
        "commodityDiscount" => "", //优惠信息 内容是根据优惠券信息，或者折价数目等等交易折扣的金额。该金额表示原始金额和交易实际金额的差值。本域中不带小数点，小数位根据6.24　交易币种来决定。
        "transferFee"       => "", //运输费用
        "customerName"      => "",//持卡人姓名
        "defaultPayType"    => "", //默认支付方式
        "defaultBankNumber" => "",//默认银行编码
        "transTimeout"      => "",//交易超时时间 交易发生时，该笔交易在银联互联网系统中有效的最长时间。当距离交易开始日期时间超过该时间时，银联互联网系统不再为该笔交易提供支付服务。
        "merReserved"       => "", //商户保留域
    );

    //支付请求必填字段检查
    static $pay_params_check = array(
        "version",//消息版本号
        "charset",//字符编码
        "transType", //指明了交易的种类  交易类型分段区分 01—30  金融类交易;31—60  金融撤销类交易;61—65  收单机构发起的金融通知类交易;66—70  发卡机构发起的金融通知类交易;71—80  不涉及资金的其他交易;81--99  公共支付类交易
        "origQid", //原始交易流水号
        "merId", //商户代码。该商户应是已被批准加入银联互联网系统的商户网站的代码。由中国银联互联网系统统一分配，不得重复。 对所有的请求报文，该域必须出现，且在整个交易周期中保持不变
        "merAbbr", //商户代码对应的商户名称。一般出现在显示给持卡人的页面中。一般用于请求消息中，表示商户名称。
        "acqCode",//收单机构代码      当商户直接与银联互联网系统相连时，该域可不出现当商户通过其他系统间接与银联互联网系统相连时，该域必须出现
        "merCode",  //商户类型      n4，4位定长数字字符 ;商户类型码表示商户的服务范围和属性
        "commodityUrl", //商品URL     Goods URL
        "commodityName", //商品名称 
        "commodityUnitPrice",//商品单价
        "commodityQuantity",//商品数量
        "commodityDiscount",//优惠信息
        "transferFee",//运输费用
        "orderNumber", //商户订单号 用于传送商户订单号信息，最大为32个字节的信息。
        "orderAmount",//交易金额
        "orderCurrency",//交易币种
        "orderTime",//交易开始日期时间
        "customerIp", //持卡人IP
        "customerName", //持卡人姓名
        "defaultPayType",//默认支付方式
        "defaultBankNumber",//默认银行编码 
        "transTimeout",//交易超时时间 
        "frontEndUrl",//返回URL 
        "backEndUrl",   //当完成买家账户向商户账户的支付时,要求商户返回URL收到通知后进行响应。最大256个（字母、数字和特殊字符）的商户网站URL ;商户网站的后台URL。绝对地址; 
        "merReserved", //商户保留域 
    );

    //查询请求必填字段检查
    static $query_params_check = array(
        "version",//消息版本号
        "charset",//字符编码
        "transType",//交易类型
        "merId",//商户代码
        "orderNumber", //商户订单号  用于传送商户订单号信息，最大为32个字节的信息。
        "orderTime",//交易开始日期时间
        "merReserved",//商户保留域
    );

    //商户保留域可能包含的字段
    static $mer_params_reserved = array(
    //  NEW NAME            OLD NAME
        "cardNumber",       "pan",
        "cardPasswd",       "password",
        "credentialType",   "idType",
        "cardCvn2",         "cvn",
        "cardExpire",       "expire",
        "credentialNumber", "idNo",
        "credentialName",   "name",
        "phoneNumber",      "mobile",
        "merAbstract",

        //tdb only
        "orderTimeoutDate",
        "origOrderNumber",
        "origOrderTime",
    );

    static $notify_param_check = array(
        "version",    //
        "charset",    //
        "transType",    //交易类型 
        "respCode",    //响应码
        "respMsg",    //响应信息
        "respTime", //交易完成日期时间  该笔交易银联互联网系统收到发卡机构应答时的时间。
        "merId",    //  商户代码
        "merAbbr",    //商户名称
        "orderNumber", //商户订单号  用于传送商户订单号信息，最大为32个字节的信息。
        "traceNumber",    //系统跟踪号 
        "traceTime",    //系统跟踪时间 
        "qid",    //交易流水号
        "orderAmount",    //交易金额
        "orderCurrency",    //交易币种
        "settleAmount",//清算金额
        "settleCurrency",//清算币种
        "settleDate",//清算日期
        "exchangeRate",//清算汇率
        "exchangeDate",//兑换日期
        "cupReserved",//系统保留域
        "signMethod", //签名方法 
        "signature",//签名信息
    );

    static $sign_ignore_params = array(
        "bank",
    );
}

?>
