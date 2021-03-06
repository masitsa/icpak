<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "admin";
$route['404_override'] = '';

/*
*	Site Routes
*/
$route['home'] = 'site/home_page';
$route['about'] = 'site/about';
$route['terms'] = 'site/terms';

/*
*	Settings Routes
*/
$route['settings'] = 'admin/settings';
$route['dashboard'] = 'admin/index';

/*
*	Login Routes
*/
$route['login-admin'] = 'login/login_admin';
$route['logout-admin'] = 'login/logout_admin';

/*
*	Users Routes
*/
$route['all-users'] = 'admin/users';
$route['all-users/(:num)'] = 'admin/users/index/$1';
$route['add-user'] = 'admin/users/add_user';
$route['edit-user/(:num)'] = 'admin/users/edit_user/$1';
$route['delete-user/(:num)'] = 'admin/users/delete_user/$1';
$route['activate-user/(:num)'] = 'admin/users/activate_user/$1';
$route['deactivate-user/(:num)'] = 'admin/users/deactivate_user/$1';
$route['reset-user-password/(:num)'] = 'admin/users/reset_password/$1';
$route['admin-profile/(:num)'] = 'admin/users/admin_profile/$1';
/*
*	Categories Routes
*/
$route['admin/all-categories'] = 'admin/categories/index';
$route['admin/all-categories/(:num)'] = 'admin/categories/index/$1';
$route['admin/add-category'] = 'admin/categories/add_category';
$route['admin/edit-category/(:num)'] = 'admin/categories/edit_category/$1';
$route['admin/delete-category/(:num)'] = 'admin/categories/delete_category/$1';
$route['admin/activate-category/(:num)'] = 'admin/categories/activate_category/$1';
$route['admin/deactivate-category/(:num)'] = 'admin/categories/deactivate_category/$1';

/*
*	Admin Blog Routes
*/
$route['posts'] = 'admin/blog';
$route['all-posts'] = 'admin/blog';
$route['blog-categories'] = 'admin/blog/categories';
$route['add-post'] = 'admin/blog/add_post';
$route['edit-post/(:num)'] = 'admin/blog/edit_post/$1';
$route['delete-post/(:num)'] = 'admin/blog/delete_post/$1';
$route['activate-post/(:num)'] = 'admin/blog/activate_post/$1';
$route['deactivate-post/(:num)'] = 'admin/blog/deactivate_post/$1';
$route['post-comments/(:num)'] = 'admin/blog/post_comments/$1';
$route['comments/(:num)'] = 'admin/blog/comments/$1';
$route['comments'] = 'admin/blog/comments';
$route['add-comment/(:num)'] = 'admin/blog/add_comment/$1';
$route['delete-comment/(:num)/(:num)'] = 'admin/blog/delete_comment/$1/$2';
$route['activate-comment/(:num)/(:num)'] = 'admin/blog/activate_comment/$1/$2';
$route['deactivate-comment/(:num)/(:num)'] = 'admin/blog/deactivate_comment/$1/$2';
$route['add-blog-category'] = 'admin/blog/add_blog_category';
$route['edit-blog-category/(:num)'] = 'admin/blog/edit_blog_category/$1';
$route['delete-blog-category/(:num)'] = 'admin/blog/delete_blog_category/$1';
$route['activate-blog-category/(:num)'] = 'admin/blog/activate_blog_category/$1';
$route['deactivate-blog-category/(:num)'] = 'admin/blog/deactivate_blog_category/$1';
$route['delete-comment/(:num)'] = 'admin/blog/delete_comment/$1';
$route['activate-comment/(:num)'] = 'admin/blog/activate_comment/$1';
$route['deactivate-comment/(:num)'] = 'admin/blog/deactivate_comment/$1';

/*
*	Blog Routes
*/
$route['blog'] = 'blog';
$route['blog/(:num)'] = 'blog/index/$1';
$route['blog/(:num)/(:num)'] = 'blog/index/$1/$2';
$route['blog/post/(:num)'] = 'blog/view_post/$1';
$route['blog/category/(:num)'] = 'blog/index/$1';
$route['blog/category/(:num)/(:num)'] = 'blog/index/$1/$2';


/*
*	Events Routes
*/
$route['all-events'] = 'admin/event';
$route['event-categories'] = 'admin/event/categories';
$route['add-event'] = 'admin/event/add_event';
$route['edit-event/(:num)'] = 'admin/event/edit_event/$1';
$route['delete-event/(:num)'] = 'admin/event/delete_event/$1';
$route['activate-event/(:num)'] = 'admin/event/activate_event/$1';
$route['deactivate-event/(:num)'] = 'admin/event/deactivate_event/$1';

/*
*	Events Routes
*/
$route['all-event-session'] = 'admin/event_session';
$route['add-event-session'] = 'admin/event_session/add_event_session';
$route['edit-event-session/(:num)'] = 'admin/event_session/edit_event_session/$1';
$route['delete-event-session/(:num)'] = 'admin/event_session/delete_event_session/$1';
$route['activate-event-session/(:num)'] = 'admin/event_session/activate_event_session/$1';
$route['deactivate-event-session/(:num)'] = 'admin/event_session/deactivate_event_session/$1';


/*
*	Session Admins Routes
*/
$route['all-session-admin'] = 'admin/session_admins';
$route['add-session-admin'] = 'admin/session_admins/add_session_admin';
$route['delete-session-admin/(:num)'] = 'admin/session_admins/delete_session_admin/$1';


$route['my-sessions'] = 'admin/account';
$route['respond-to-question/(:num)'] = 'admin/account/respond_to_question/$1';
$route['feedback'] = 'admin/feedback/index';
$route['feedback/(:num)'] = 'admin/feedback/index/$1';




/*
*	Blog Routes
*/
$route['meetings'] = 'admin/meeting';
$route['all-meetings'] = 'admin/meeting';
$route['meeting-categories'] = 'admin/meeting/categories';
$route['add-meeting'] = 'admin/meeting/add_meeting';
$route['edit-meeting/(:num)'] = 'admin/meeting/edit_meeting/$1';
$route['delete-meeting/(:num)'] = 'admin/meeting/delete_meeting/$1';
$route['activate-meeting/(:num)'] = 'admin/meeting/activate_meeting/$1';
$route['deactivate-meeting/(:num)'] = 'admin/meeting/deactivate_meeting/$1';

$route['meeting-comments/(:num)'] = 'admin/meeting/meeting_comments/$1';
$route['comments/(:num)'] = 'admin/meeting/comments/$1';
$route['comments'] = 'admin/meeting/comments';
$route['add-comment/(:num)'] = 'admin/meeting/add_comment/$1';
$route['delete-comment/(:num)/(:num)'] = 'admin/meeting/delete_comment/$1/$2';
$route['activate-comment/(:num)/(:num)'] = 'admin/meeting/activate_comment/$1/$2';
$route['deactivate-comment/(:num)/(:num)'] = 'admin/meeting/deactivate_comment/$1/$2';

$route['add-meeting-category'] = 'admin/meeting/add_meeting_category';
$route['edit-meeting-category/(:num)'] = 'admin/meeting/edit_meeting_category/$1';
$route['delete-meeting-category/(:num)'] = 'admin/meeting/delete_meeting_category/$1';
$route['activate-meeting-category/(:num)'] = 'admin/meeting/activate_meeting_category/$1';
$route['deactivate-meeting-category/(:num)'] = 'admin/meeting/deactivate_meeting_category/$1';
$route['delete-comment/(:num)'] = 'admin/meeting/delete_comment/$1';
$route['activate-comment/(:num)'] = 'admin/meeting/activate_comment/$1';
$route['deactivate-comment/(:num)'] = 'admin/meeting/deactivate_comment/$1';
/*
*	meeting Routes
*/


$route['meeting-bookings/(:num)'] = 'admin/meeting/meeting_bookings/$1';
$route['bookings/(:num)'] = 'admin/meeting/bookings/$1';
$route['bookings'] = 'admin/meeting/bookings';
$route['delete-booking/(:num)/(:num)'] = 'admin/meeting/delete_booking/$1/$2';
$route['activate-booking/(:num)/(:num)'] = 'admin/meeting/activate_booking/$1/$2';
$route['deactivate-booking/(:num)/(:num)'] = 'admin/meeting/deactivate_booking/$1/$2';
$route['activate-booking/(:num)'] = 'admin/meeting/activate_booking/$1';
$route['deactivate-booking/(:num)'] = 'admin/meeting/deactivate_booking/$1';


/*
*	Queries Routes
*/

$route['technical-queries'] = 'admin/query/technical_query';
$route['activate-query/(:num)'] = 'admin/query/activate_query/$1';
$route['deactivate-query/(:num)'] = 'admin/query/deactivate_query/$1';
$route['delete-query/(:num)'] = 'admin/query/delete_query/$1';


/*
*	Standards Queries Routes
*/

$route['standards-queries'] = 'admin/query/standards_query';
$route['activate-standards-query/(:num)'] = 'admin/query/activate_standards_query/$1';
$route['deactivate-standards-query/(:num)'] = 'admin/query/deactivate_standards_query/$1';
$route['delete-standards-query/(:num)'] = 'admin/query/delete_standards_query/$1';

/*
*	Vendor Routes
*/
$route['vendor/sign-up/user-details'] = 'vendor/vendor_signup1';
$route['vendor/sign-up/personal-details'] = 'vendor/vendor_signup1';
$route['vendor/sign-up/store-details'] = 'vendor/vendor_signup2';
$route['vendor/sign-up/subscribe'] = 'vendor/vendor_signup3';
$route['vendor/subscribe/free'] = 'vendor/subscribe/1';
$route['vendor/subscribe/basic'] = 'vendor/subscribe/2';
$route['vendor/subscribe/unlimited'] = 'vendor/subscribe/3';
$route['vendor/sign-in'] = 'vendor/vendor_signin';
$route['vendor/sign-out'] = 'vendor/vendor_signout';
$route['confirm-account/(:any)'] = 'vendor/verify_email/$1';



/*
*	site Routes
*/

$route['site/sign-in'] = 'site/user_signin';

$route['site/home'] = 'site/index';
$route['messages'] = 'site/messages';
$route['profile'] = 'site/profile';
$route['timeline'] = 'site/index';
$route['events'] = 'site/events';
$route['events/view-event/(:num)'] = 'site/view_event/$1';
$route['events/book-event/(:num)'] = 'site/book_event/$1';
$route['events/open-event/(:num)'] = 'site/open_event/$1';




/*
*	Categories Routes
*/
$route['vendor/all-categories'] = 'vendor/categories/index';
$route['vendor/add-category'] = 'vendor/categories/add_category';
$route['vendor/edit-category/(:num)'] = 'vendor/categories/edit_category/$1';
$route['vendor/delete-category/(:num)'] = 'vendor/categories/delete_category/$1';
$route['vendor/activate-category/(:num)'] = 'vendor/categories/activate_category/$1';
$route['vendor/deactivate-category/(:num)'] = 'vendor/categories/deactivate_category/$1';

/*
*	Orders Routes
*/
$route['vendor/all-orders'] = 'vendor/orders/index';
$route['vendor/add-order'] = 'vendor/orders/add_order';
$route['vendor/edit-order/(:num)'] = 'vendor/orders/edit_order/$1';
$route['vendor/delete-order/(:num)'] = 'vendor/orders/delete_order/$1';
$route['vendor/deactivate-order/(:num)'] = 'vendor/orders/deactivate_order/$1';
$route['vendor/finish-order/(:num)'] = 'vendor/orders/finish_order/$1';
$route['vendor/cancel-order/(:num)'] = 'vendor/orders/cancel_order/$1';
$route['vendor/orders/add-product/(:num)/(:num)/(:num)/(:num)'] = 'vendor/orders/add_product/$1/$2/$3/$4';
$route['vendor/orders/update-cart/(:num)/(:num)/(:num)'] = 'vendor/orders/update_cart/$1/$2/$3';
$route['vendor/orders/delete-order-item/(:num)/(:num)'] = 'vendor/orders/delete_order_item/$1/$2';

/*
*	Features Routes
*/
$route['vendor/all-features'] = 'vendor/features/index';
$route['vendor/add-feature'] = 'vendor/features/add_feature';
$route['vendor/edit-feature/(:num)'] = 'vendor/features/edit_feature/$1';
$route['vendor/delete-feature/(:num)'] = 'vendor/features/delete_feature/$1';
$route['vendor/activate-feature/(:num)'] = 'vendor/features/activate_feature/$1';
$route['vendor/deactivate-feature/(:num)'] = 'vendor/features/deactivate_feature/$1';

/*
*	Products Routes
*/
$route['vendor/all-products'] = 'vendor/products/index';
$route['vendor/search-products'] = 'vendor/products/search_products';
$route['vendor/close-product-search'] = 'vendor/products/close_product_search';
$route['vendor/add-product'] = 'vendor/products/add_product';
$route['vendor/export-product'] = 'vendor/products/export_products';
$route['vendor/import-product'] = 'vendor/products/import_products';
$route['vendor/import-template'] = 'vendor/products/import_template';
$route['vendor/validate-import'] = 'vendor/products/do_products_import';
$route['vendor/import-categories'] = 'vendor/products/import_categories';
$route['vendor/edit-product/(:num)'] = 'vendor/products/edit_product/$1';
$route['vendor/delete-product/(:num)'] = 'vendor/products/delete_product/$1';
$route['vendor/activate-product/(:num)'] = 'vendor/products/activate_product/$1';
$route['vendor/deactivate-product/(:num)'] = 'vendor/products/deactivate_product/$1';

/*
*	Products Routes
*/
$route['vendor/all-product-bundle'] = 'vendor/products/all_product_bundles';
$route['vendor/search-products-to-bundle/(:num)'] = 'vendor/products/search_product_to_bundles/$1';
$route['vendor/close-product-to-bundle-search/(:num)'] = 'vendor/products/close_product_to_bundle_search/$1';
$route['vendor/add-product-bundle'] = 'vendor/products/add_product_bundle';
$route['vendor/add-product-bundle-items/(:num)'] = 'vendor/products/add_product_bundle_items/$1';
$route['vendor/add-product-to-bundle/(:num)/(:num)'] = 'vendor/products/add_product_to_bundle/$1/$2';
$route['vendor/activate-product-from-bundle/(:num)/(:num)'] = 'vendor/products/activate_product_from_bundle/$1/$2';
$route['vendor/deactivate-product-from-bundle/(:num)/(:num)'] = 'vendor/products/deactivate_product_from_bundle/$1/$2';



/*
*	Brands Routes
*/
$route['vendor/all-brands'] = 'vendor/brands/index';
$route['vendor/add-brand'] = 'vendor/brands/add_brand';
$route['vendor/edit-brand/(:num)'] = 'vendor/brands/edit_brand/$1';
$route['vendor/delete-brand/(:num)'] = 'vendor/brands/delete_brand/$1';
$route['vendor/activate-brand/(:num)'] = 'vendor/brands/activate_brand/$1';
$route['vendor/deactivate-brand/(:num)'] = 'vendor/brands/deactivate_brand/$1';

/*
*	Products Routes
*/
$route['products/new-products'] = 'site/products/__/0/0/created/1';
$route['products/new-category'] = 'site/products/__/0/0/created/0/1';
$route['products/new-brand'] = 'site/products/__/0/0/created/0/0/1';
$route['products/category/(:num)'] = 'site/products/__/$1';
$route['products/brand/(:num)'] = 'site/products/__/0/$1';
$route['products/category'] = 'site/products/__/0';
$route['products/brand'] = 'site/products/__/0';
$route['products/brand/(:num)'] = 'site/products/__/0/$1';
$route['products/all-products'] = 'site/products/__/0';
$route['products'] = 'site/products/__/0';
$route['products/search'] = 'site/search';
$route['products/search/(:any)'] = 'site/products/$1';
$route['products/price-range/(:any)'] = 'site/products/__/0/0/created/0/0/0/$1';
$route['products/filter-brands/(:any)'] = 'site/products/__/0/0/created/0/0/0/__/$1';
$route['products/filter-brands'] = 'site/filter_brands';
$route['products/sort-by/(:any)'] = 'site/products/__/0/0/$1';
$route['products/view-product/(:num)'] = 'site/view_product/$1';

/*
*	Cart Routes
*/
$route['cart'] = 'site/cart/view_cart';
$route['cart/delete-item/(:any)/(:num)'] = 'site/cart/delete_cart_item/$1/$2';
$route['cart/update-cart'] = 'site/cart/update_cart';

/*
*	Account Routes
*/
$route['account'] = 'site/account/my_account';
$route['account/orders-list'] = 'site/account/orders_list';
$route['account/my-details'] = 'site/account/my_details';
$route['account/wishlist'] = 'site/account/wishlist';
$route['account/update-details'] = 'site/account/update_account';
$route['account/update-password'] = 'site/account/update_password';
$route['account/sign-out'] = 'login/logout_user';

/*
*	Checkout Routes
*/
$route['checkout'] = 'site/checkout/checkout_user';
$route['checkout/register'] = 'site/checkout/register';
$route['checkout/login'] = 'site/checkout/login_user/1';
$route['checkout/my-details'] = 'site/checkout/my_details';
$route['checkout-progress'] = 'site/checkout/checkout_progress';
$route['checkout-progress/(:any)'] = 'site/checkout/checkout_progress/$1';
$route['checkout/delivery'] = 'site/checkout/delivery';
$route['checkout/payment'] = 'site/checkout/payment_options';
$route['checkout/order'] = 'site/checkout/order_details';
$route['checkout/add-delivery-instructions'] = 'site/checkout/add_delivery_instructions';
$route['checkout/add-payment-options'] = 'site/checkout/add_payment_options';
$route['checkout/confirm-order'] = 'site/checkout/confirm_order';

$route['forgot-password'] = 'site/checkout/forgot_password';


/* End of file routes.php */
/* Location: ./application/config/routes.php */


/*
* Countries routes
*/ 

$route['all-country'] = 'admin/country/index';
$route['all-country/(:num)'] = 'admin/country/index/$1';
$route['add-country'] = 'admin/country/add_country';
$route['edit-country/(:num)'] = 'admin/country/edit_country/$1';
$route['delete-country/(:num)'] = 'admin/country/delete_country/$1';
$route['activate-country/(:num)'] = 'admin/country/activate_country/$1';
$route['deactivate-country/(:num)'] = 'admin/country/deactivate_country/$1';



/*
* Event type routes
*/ 

$route['all-event-type'] = 'admin/event_type/index';
$route['all-event-type/(:num)'] = 'admin/event_type/index/$1';
$route['add-event-type'] = 'admin/event_type/add_event_type';
$route['edit-event-type/(:num)'] = 'admin/event_type/edit_event_type/$1';
$route['delete-event-type/(:num)'] = 'admin/event_type/delete_event_type/$1';
$route['activate-event-type/(:num)'] = 'admin/event_type/activate_event_type/$1';
$route['deactivate-event-type/(:num)'] = 'admin/event_type/deactivate_event_type/$1';


/*
*	Members Routes
*/
$route['all-member'] = 'admin/members';
$route['all-member/(:num)'] = 'admin/members/index/$1';
$route['delete-member/(:num)'] = 'admin/members/delete_member/$1';
$route['activate-member/(:num)'] = 'admin/members/activate_member/$1';
$route['deactivate-member/(:num)'] = 'admin/members/deactivate_member/$1';


$route['send-query-response/(:num)'] = 'admin/query/send_query_response/$1';
$route['live-stream'] = 'admin/live_streaming/index';


/*
*	Members Routes
*/
$route['all-recording'] = 'admin/recordings';
$route['all-recording/(:num)'] = 'admin/recordings/index/$1';
$route['delete-recording/(:num)'] = 'admin/recordings/delete_recording/$1';
$route['activate-recording/(:num)'] = 'admin/recordings/activate_recording/$1';
$route['deactivate-recording/(:num)'] = 'admin/recordings/deactivate_recording/$1';
$route['add-recording'] = 'admin/recordings/add_recording';
$route['edit-recording/(:num)'] = 'admin/recordings/edit_recording/$1';