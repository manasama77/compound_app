<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller']   = 'WelcomeController';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

$route['login']      						= 'LoginController/index';
$route['auth']       						= 'LoginController/auth';
$route['otp']        						= 'LoginController/otp';
$route['otp_auth']   						= 'LoginController/otp_auth';
$route['otp_resend'] 						= 'LoginController/otp_resend';
$route['logout']     						= 'LoginController/logout';
$route['activate/(:any)/(:any)'] 			= 'LoginController/activate/$1/$2';
$route['registration/success']				= 'LoginController/registration_success';
$route['registration/activation/resend']	= 'LoginController/activation_resend';
$route['registration/(:any)/(:any)']		= 'LoginController/registration/$1/$2';
$route['forgot_password']					= 'LoginController/forgot_password';
$route['send_forgot_password']				= 'LoginController/send_forgot_password';
$route['reset_password/(:any)/(:any)'] 		= 'LoginController/reset_password/$1/$2';

$route['dashboard']                 = 'DashboardController/index';
$route['dashboard/downline_detail'] = 'DashboardController/downline_detail';

$route['profile']                = 'ProfileController/index';
$route['setting_update']         = 'ProfileController/setting_update';
$route['check_current_password'] = 'ProfileController/check_current_password';
$route['update_password']        = 'ProfileController/update_password';
$route['reset_password']         = 'ProfileController/reset_password';

$route['trade_manager']                     	= 'TradeManagerController/index';
$route['trade_manager/add']                     = 'TradeManagerController/add';
$route['trade_manager/pick/(:any)']             = 'TradeManagerController/pick/$1';
$route['trade_manager/checkout/coinpayment'] 	= 'TradeManagerController/checkout_coinpayment';
$route['trade_manager/checkout/(:any)']   		= 'TradeManagerController/checkout/$1';
$route['trade_manager/detail']   				= 'TradeManagerController/detail';
$route['trade_manager/update_extend']   		= 'TradeManagerController/update_extend';

$route['crypto_asset']     						= 'CryptoAssetController/index';
$route['crypto_asset/add'] 						= 'CryptoAssetController/add';
$route['crypto_asset/pick/(:any)']             	= 'CryptoAssetController/pick/$1';
$route['crypto_asset/checkout/coinpayment'] 	= 'CryptoAssetController/checkout_coinpayment';
$route['crypto_asset/checkout/(:any)']   		= 'CryptoAssetController/checkout/$1';
$route['crypto_asset/detail']   				= 'CryptoAssetController/detail';

$route['downline']      = 'DownlineController/index';
$route['downline/show'] = 'DownlineController/show';

$route['wallet']         = 'WalletController/index';
$route['wallet/store']   = 'WalletController/store';
$route['wallet/update']  = 'WalletController/update';
$route['wallet/destroy'] = 'WalletController/destroy';

$route['withdraw'] 							= 'WithdrawController/index';
$route['withdraw_auth'] 					= 'WithdrawController/auth';
$route['withdraw_rates'] 					= 'WithdrawController/rates';
$route['withdraw_render_wallet_label'] 		= 'WithdrawController/render_wallet_label';
$route['withdraw_render_wallet_address'] 	= 'WithdrawController/render_wallet_address';
$route['withdraw/otp'] 						= 'WithdrawController/otp';
$route['withdraw/process'] 					= 'WithdrawController/process';
$route['withdraw/success/(:any)'] 			= 'WithdrawController/success/$1';

$route['rewards'] = 'RewardsController/index';

$route['log/trade_manager'] 				= 'LogTradeManagerController/index';
$route['log/trade_manager/detail/(:any)'] 	= 'LogTradeManagerController/detail/$1';

$route['log/crypto_asset'] 				  	= 'LogCryptoAssetController/index';
$route['log/crypto_asset/detail/(:any)'] 	= 'LogCryptoAssetController/detail/$1';

$route['log/recruitment']   = 'LogRecruitmentController/index';

$route['log/withdraw'] = 'LogWithdrawController/index';

$route['init']         = 'InitController/init';
$route['init/country'] = 'InitController/country';
$route['base64']       = 'InitController/base64';
$route['send_email']   = 'SendEmail';

$route['coinpayment/get_basic_info']         = 'CoinPayment/get_basic_info';
$route['coinpayment/rates']                  = 'CoinPayment/rates';
$route['coinpayment/create_transaction']     = 'CoinPayment/create_transaction';
$route['coinpayment/callback_address']       = 'CoinPayment/callback_address';
$route['coinpayment/get_tx_info']            = 'CoinPayment/get_tx_info';
$route['coinpayment/get_tx_ids']             = 'CoinPayment/get_tx_ids';
$route['coinpayment/balances']               = 'CoinPayment/balances';
$route['coinpayment/create_transfer']        = 'CoinPayment/create_transfer';
$route['coinpayment/create_withdrawal']      = 'CoinPayment/create_withdrawal';
$route['coinpayment/cancel_withdrawal']      = 'CoinPayment/cancel_withdrawal';
$route['coinpayment/convert']                = 'CoinPayment/convert';
$route['coinpayment/convert_limits']         = 'CoinPayment/convert_limits';
$route['coinpayment/get_withdrawal_history'] = 'CoinPayment/get_withdrawal_history';
$route['coinpayment/get_withdrawal_info']    = 'CoinPayment/get_withdrawal_info';
$route['coinpayment/ipn']      = 'CoinPayment/ipn';

$route['coinpayment/success/(:any)']  = 'CoinPayment/success/$1';
$route['coinpayment/cancel/(:any)']   = 'CoinPayment/cancel/$1';

$route['scheduler/profit_daily_trade_manager']  = 'TaskSchedulerController/profit_daily_trade_manager'; # done check
$route['scheduler/profit_daily_crypto_asset']   = 'TaskSchedulerController/profit_daily_crypto_asset'; # done check
$route['scheduler/withdraw']                    = 'TaskSchedulerController/withdraw'; # done check
$route['scheduler/reward']                      = 'TaskSchedulerController/reward';
$route['scheduler/check_trade_manager_expired'] = 'TaskSchedulerController/check_trade_manager_expired';
$route['scheduler/check_crypto_asset_expired'] 	= 'TaskSchedulerController/check_crypto_asset_expired';
$route['scheduler/coinpayment_tx_info_tm'] 	    = 'TaskSchedulerController/coinpayment_tx_info_tm'; # done check

$route['test'] = 'TestController/index';
