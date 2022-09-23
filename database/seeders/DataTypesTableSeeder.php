<?php

namespace Database\Seeders;

use App\Audio;
use App\Article;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\BrandCategoryText;
use App\Models\Category;
use App\Company;
use App\CV;
use App\FixedCompany;
use App\Gallery;
use App\Models\Gender;
use App\Http\Controllers\Voyager\VoyagerOrderController;
use App\Http\Controllers\Voyager\VoyagerPollController;
use App\Http\Controllers\Voyager\VoyagerProductAttributesTemplateController;
use App\Http\Controllers\Voyager\VoyagerProductController;
use App\Http\Controllers\Voyager\VoyagerPublicationController;
use App\Http\Controllers\Voyager\VoyagerUserController;
use App\Http\Controllers\Voyager\VoyagerRoleController;
use App\Http\Controllers\Voyager\VoyagerSubscriberController;
use App\ImportPartner;
use App\ImportPartnerMargin;
use App\News;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PartnerInstallment;
use App\Models\PaymentMethod;
use App\Photo;
use App\Models\Poll;
use App\Models\PollAnswer;
use App\Pricelist;
use App\Models\Product;
use App\Models\ProductAttributesTemplate;
use App\Models\ProductGroup;
use App\Models\Project;
use App\Models\Promotion;
use App\Models\Publication;
use App\Pubrubric;
use App\Models\Redirect;
use App\Models\Review;
use App\Models\Rubric;
use App\Serrubric;
use App\Service;
use App\Models\ShippingMethod;
use App\Models\Shop;
use App\Specialist;
use App\Specialization;
use App\Models\StaticText;
use App\Models\Sticker;
use App\Models\Store;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\UserApplication;
use App\Vacancy;
use App\Video;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Policies\UserPolicy;

class DataTypesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('data_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $dataTypeItems = [
            // main rows
            [
                'slug'                  => 'users',
                'name'                  => 'users',
                'display_name_singular' => __('seeders.data_types.user.singular'),
                'display_name_plural'   => __('seeders.data_types.user.plural'),
                'icon'                  => 'voyager-person',
                'model_name'            => User::class,
                'controller'            => VoyagerUserController::class,
                'policy_name'           => UserPolicy::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => 'status',
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'menus',
                'name'                  => 'menus',
                'display_name_singular' => __('seeders.data_types.menu.singular'),
                'display_name_plural'   => __('seeders.data_types.menu.plural'),
                'icon'                  => 'voyager-list',
                'model_name'            => Menu::class,
            ],
            [
                'slug'                  => 'roles',
                'name'                  => 'roles',
                'display_name_singular' => __('seeders.data_types.role.singular'),
                'display_name_plural'   => __('seeders.data_types.role.plural'),
                'icon'                  => 'voyager-lock',
                'model_name'            => Role::class,
                'controller'            => VoyagerRoleController::class,
            ],
            [
                'slug'                  => 'pages',
                'name'                  => 'pages',
                'display_name_singular' => __('seeders.data_types.page.singular'),
                'display_name_plural'   => __('seeders.data_types.page.plural'),
                'icon'                  => 'voyager-file-text',
                'model_name'            => Page::class,
            ],

            // additional rows
            [
                'slug'                  => 'banners',
                'name'                  => 'banners',
                'display_name_singular' => __('seeders.data_types.banner.singular'),
                'display_name_plural'   => __('seeders.data_types.banner.plural'),
                'icon'                  => 'voyager-images',
                'model_name'            => Banner::class,
            ],
            [
                'slug'                  => 'brands',
                'name'                  => 'brands',
                'display_name_singular' => __('seeders.data_types.brand.singular'),
                'display_name_plural'   => __('seeders.data_types.brand.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Brand::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => 'name',
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'projects',
                'name'                  => 'projects',
                'display_name_singular' => __('seeders.data_types.project.singular'),
                'display_name_plural'   => __('seeders.data_types.project.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Project::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => 'name',
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'categories',
                'name'                  => 'categories',
                'display_name_singular' => __('seeders.data_types.category.singular'),
                'display_name_plural'   => __('seeders.data_types.category.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Category::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => 'name',
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'companies',
                'name'                  => 'companies',
                'display_name_singular' => __('seeders.data_types.company.singular'),
                'display_name_plural'   => __('seeders.data_types.company.plural'),
                'icon'                  => 'voyager-company',
                'model_name'            => Company::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => 'status',
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'products',
                'name'                  => 'products',
                'display_name_singular' => __('seeders.data_types.product.singular'),
                'display_name_plural'   => __('seeders.data_types.product.plural'),
                'icon'                  => 'voyager-basket',
                'model_name'            => Product::class,
                'controller'            => VoyagerProductController::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => 'name',
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'attributes',
                'name'                  => 'attributes',
                'display_name_singular' => __('seeders.data_types.attribute.singular'),
                'display_name_plural'   => __('seeders.data_types.attribute.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Attribute::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => 'name',
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'attribute_values',
                'name'                  => 'attribute_values',
                'display_name_singular' => __('seeders.data_types.attribute_value.singular'),
                'display_name_plural'   => __('seeders.data_types.attribute_value.plural'),
                'icon'                  => 'voyager-wand',
                'model_name'            => AttributeValue::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => 'name',
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'product_attributes_templates',
                'name'                  => 'product_attributes_templates',
                'display_name_singular' => __('seeders.data_types.product_attributes_template.singular'),
                'display_name_plural'   => __('seeders.data_types.product_attributes_template.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => ProductAttributesTemplate::class,
                'controller'            => VoyagerProductAttributesTemplateController::class,
            ],
            [
                'slug'                  => 'publications',
                'name'                  => 'publications',
                'display_name_singular' => __('seeders.data_types.publication.singular'),
                'display_name_plural'   => __('seeders.data_types.publication.plural'),
                'icon'                  => 'voyager-news',
                'model_name'            => Publication::class,
                'controller'            => VoyagerPublicationController::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'promotions',
                'name'                  => 'promotions',
                'display_name_singular' => __('seeders.data_types.promotion.singular'),
                'display_name_plural'   => __('seeders.data_types.promotion.plural'),
                'icon'                  => 'voyager-news',
                'model_name'            => Promotion::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => 'name',
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'rubrics',
                'name'                  => 'rubrics',
                'display_name_singular' => __('seeders.data_types.rubric.singular'),
                'display_name_plural'   => __('seeders.data_types.rubric.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Rubric::class,
            ],
            [
                'slug'                  => 'services',
                'name'                  => 'services',
                'display_name_singular' => __('seeders.data_types.service.singular'),
                'display_name_plural'   => __('seeders.data_types.service.plural'),
                'icon'                  => 'voyager-receipt',
                'model_name'            => Service::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'specializations',
                'name'                  => 'specializations',
                'display_name_singular' => __('seeders.data_types.specialization.singular'),
                'display_name_plural'   => __('seeders.data_types.specialization.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Specialization::class,
            ],
            [
                'slug'                  => 'specialists',
                'name'                  => 'specialists',
                'display_name_singular' => __('seeders.data_types.specialist.singular'),
                'display_name_plural'   => __('seeders.data_types.specialist.plural'),
                'icon'                  => 'voyager-people',
                'model_name'            => Specialist::class,
            ],
            [
                'slug'                  => 'articles',
                'name'                  => 'articles',
                'display_name_singular' => __('seeders.data_types.article.singular'),
                'display_name_plural'   => __('seeders.data_types.article.plural'),
                'icon'                  => 'voyager-documentation',
                'model_name'            => Article::class,
            ],
            [
                'slug'                  => 'news',
                'name'                  => 'news',
                'display_name_singular' => __('seeders.data_types.news.singular'),
                'display_name_plural'   => __('seeders.data_types.news.plural'),
                'icon'                  => 'voyager-news',
                'model_name'            => News::class,
            ],
            [
                'slug'                  => 'audios',
                'name'                  => 'audios',
                'display_name_singular' => __('seeders.data_types.audio.singular'),
                'display_name_plural'   => __('seeders.data_types.audio.plural'),
                'icon'                  => 'voyager-sound',
                'model_name'            => Audio::class,
            ],
            [
                'slug'                  => 'videos',
                'name'                  => 'videos',
                'display_name_singular' => __('seeders.data_types.video.singular'),
                'display_name_plural'   => __('seeders.data_types.video.plural'),
                'icon'                  => 'voyager-video',
                'model_name'            => Video::class,
            ],
            [
                'slug'                  => 'vacancies',
                'name'                  => 'vacancies',
                'display_name_singular' => __('seeders.data_types.vacancy.singular'),
                'display_name_plural'   => __('seeders.data_types.vacancy.plural'),
                'icon'                  => 'voyager-news',
                'model_name'            => Vacancy::class,
            ],
            [
                'slug'                  => 'c_v_s',
                'name'                  => 'c_v_s',
                'display_name_singular' => __('seeders.data_types.c_v.singular'),
                'display_name_plural'   => __('seeders.data_types.c_v.plural'),
                'icon'                  => 'voyager-file-text',
                'model_name'            => CV::class,
            ],
            [
                'slug'                  => 'galleries',
                'name'                  => 'galleries',
                'display_name_singular' => __('seeders.data_types.gallery.singular'),
                'display_name_plural'   => __('seeders.data_types.gallery.plural'),
                'icon'                  => 'voyager-photos',
                'model_name'            => Gallery::class,
            ],
            [
                'slug'                  => 'photos',
                'name'                  => 'photos',
                'display_name_singular' => __('seeders.data_types.photo.singular'),
                'display_name_plural'   => __('seeders.data_types.photo.plural'),
                'icon'                  => 'voyager-photo',
                'model_name'            => Photo::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => null,
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'reviews',
                'name'                  => 'reviews',
                'display_name_singular' => __('seeders.data_types.review.singular'),
                'display_name_plural'   => __('seeders.data_types.review.plural'),
                'icon'                  => 'voyager-bubble',
                'model_name'            => Review::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => 'status',
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'pricelists',
                'name'                  => 'pricelists',
                'display_name_singular' => __('seeders.data_types.pricelist.singular'),
                'display_name_plural'   => __('seeders.data_types.pricelist.plural'),
                'icon'                  => 'voyager-upload',
                'model_name'            => Pricelist::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => 'status',
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'static_texts',
                'name'                  => 'static_texts',
                'display_name_singular' => __('seeders.data_types.static_text.singular'),
                'display_name_plural'   => __('seeders.data_types.static_text.plural'),
                'icon'                  => 'voyager-file-text',
                'model_name'            => StaticText::class,
            ],
            [
                'slug'                  => 'redirects',
                'name'                  => 'redirects',
                'display_name_singular' => __('seeders.data_types.redirect.singular'),
                'display_name_plural'   => __('seeders.data_types.redirect.plural'),
                'icon'                  => 'voyager-forward',
                'model_name'            => Redirect::class,
                'server_side'           => 1,
                'details'               => [
                    "order_column" => 'status',
                    "order_display_column" => null,
                    "order_direction" => "desc",
                    "default_search_key" => null,
                    "scope" => null
                ],
            ],
            [
                'slug'                  => 'orders',
                'name'                  => 'orders',
                'display_name_singular' => __('seeders.data_types.order.singular'),
                'display_name_plural'   => __('seeders.data_types.order.plural'),
                'icon'                  => 'voyager-shop',
                'controller'            => VoyagerOrderController::class,
                'model_name'            => Order::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'user_applications',
                'name'                  => 'user_applications',
                'display_name_singular' => __('seeders.data_types.user_application.singular'),
                'display_name_plural'   => __('seeders.data_types.user_application.plural'),
                'icon'                  => 'voyager-check-circle',
                'model_name'            => UserApplication::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'shops',
                'name'                  => 'shops',
                'display_name_singular' => __('seeders.data_types.shop.singular'),
                'display_name_plural'   => __('seeders.data_types.shop.plural'),
                'icon'                  => 'voyager-shop',
                'model_name'            => Shop::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'stores',
                'name'                  => 'stores',
                'display_name_singular' => __('seeders.data_types.store.singular'),
                'display_name_plural'   => __('seeders.data_types.store.plural'),
                'icon'                  => 'voyager-shop',
                'model_name'            => Store::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'genders',
                'name'                  => 'genders',
                'display_name_singular' => __('seeders.data_types.gender.singular'),
                'display_name_plural'   => __('seeders.data_types.gender.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Gender::class,
            ],
            [
                'slug'                  => 'notifications',
                'name'                  => 'notifications',
                'display_name_singular' => __('seeders.data_types.notification.singular'),
                'display_name_plural'   => __('seeders.data_types.notification.plural'),
                'icon'                  => 'voyager-bell',
                'model_name'            => Notification::class,
            ],
            [
                'slug'                  => 'polls',
                'name'                  => 'polls',
                'display_name_singular' => __('seeders.data_types.poll.singular'),
                'display_name_plural'   => __('seeders.data_types.poll.plural'),
                'icon'                  => 'voyager-megaphone',
                'model_name'            => Poll::class,
                'controller'            => VoyagerPollController::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'poll_answers',
                'name'                  => 'poll_answers',
                'display_name_singular' => __('seeders.data_types.poll_answer.singular'),
                'display_name_plural'   => __('seeders.data_types.poll_answer.plural'),
                'icon'                  => 'voyager-megaphone',
                'model_name'            => PollAnswer::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'subscribers',
                'name'                  => 'subscribers',
                'display_name_singular' => __('seeders.data_types.subscriber.singular'),
                'display_name_plural'   => __('seeders.data_types.subscriber.plural'),
                'icon'                  => 'voyager-mail',
                'model_name'            => Subscriber::class,
                'controller'            => VoyagerSubscriberController::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'warehouses',
                'name'                  => 'warehouses',
                'display_name_singular' => __('seeders.data_types.warehouse.singular'),
                'display_name_plural'   => __('seeders.data_types.warehouse.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Warehouse::class,
                // 'server_side'           => 1,
            ],
            [
                'slug'                  => 'brand_category_texts',
                'name'                  => 'brand_category_texts',
                'display_name_singular' => __('seeders.data_types.brand_category_text.singular'),
                'display_name_plural'   => __('seeders.data_types.brand_category_text.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => BrandCategoryText::class,
				'server_side'           => 1,
            ],
            [
                'slug'                  => 'partners',
                'name'                  => 'partners',
                'display_name_singular' => __('seeders.data_types.partner.singular'),
                'display_name_plural'   => __('seeders.data_types.partner.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => Partner::class,
                // 'server_side'           => 1,
            ],
            [
                'slug'                  => 'partner_installments',
                'name'                  => 'partner_installments',
                'display_name_singular' => __('seeders.data_types.partner_installment.singular'),
                'display_name_plural'   => __('seeders.data_types.partner_installment.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => PartnerInstallment::class,
                // 'server_side'           => 1,
            ],
            [
                'slug'                  => 'product_groups',
                'name'                  => 'product_groups',
                'display_name_singular' => __('seeders.data_types.product_group.singular'),
                'display_name_plural'   => __('seeders.data_types.product_group.plural'),
                'icon'                  => 'voyager-basket',
                'model_name'            => ProductGroup::class,
                'server_side'           => 1,
            ],
            [
                'slug'                  => 'import_partners',
                'name'                  => 'import_partners',
                'display_name_singular' => __('seeders.data_types.import_partner.singular'),
                'display_name_plural'   => __('seeders.data_types.import_partner.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => ImportPartner::class,
                // 'server_side'           => 1,
            ],
            [
                'slug'                  => 'import_partner_margins',
                'name'                  => 'import_partner_margins',
                'display_name_singular' => __('seeders.data_types.import_partner_margin.singular'),
                'display_name_plural'   => __('seeders.data_types.import_partner_margin.plural'),
                'icon'                  => 'voyager-categories',
                'model_name'            => ImportPartnerMargin::class,
                // 'server_side'           => 1,
            ],
            [
                'slug'                  => 'stickers',
                'name'                  => 'stickers',
                'display_name_singular' => __('seeders.data_types.sticker.singular'),
                'display_name_plural'   => __('seeders.data_types.sticker.plural'),
                'icon'                  => 'voyager-tag',
                'model_name'            => Sticker::class,
                // 'server_side'           => 1,
            ],
            [
                'slug'                  => 'payment_methods',
                'name'                  => 'payment_methods',
                'display_name_singular' => __('seeders.data_types.payment_method.singular'),
                'display_name_plural'   => __('seeders.data_types.payment_method.plural'),
                'icon'                  => 'voyager-dollar',
                'model_name'            => PaymentMethod::class,
                // 'server_side'           => 1,
            ],
            [
                'slug'                  => 'shipping_methods',
                'name'                  => 'shipping_methods',
                'display_name_singular' => __('seeders.data_types.shipping_method.singular'),
                'display_name_plural'   => __('seeders.data_types.shipping_method.plural'),
                'icon'                  => 'voyager-truck',
                'model_name'            => ShippingMethod::class,
                // 'server_side'           => 1,
            ],
        ];

        // seed data types
        $this->seedDataTypes($dataTypeItems);
    }
    /**
     * [dataType description].
     *
     * @param [type] $field [description]
     * @param [type] $for   [description]
     *
     * @return [type] [description]
     */
    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }

    /*
     * Seed all data types
     *
     * @param [array] $dataTypeItems
     *
     */
    private function seedDataTypes(array $dataTypeItems)
    {
        $modules = config('cms.modules');
        foreach ($dataTypeItems as $item) {
            if (empty($modules[$item['slug']])) {
                continue;
            }
            $dataType = $this->dataType('slug', $item['slug']);
            if (!$dataType->exists) {
                $dataType->fill([
                    'name'                  => $item['slug'],
                    'display_name_singular' => $item['display_name_singular'],
                    'display_name_plural'   => $item['display_name_plural'],
                    'icon'                  => $item['icon'],
                    'model_name'            => $item['model_name'],
                    'controller'            => $item['controller'] ?? null,
                    'policy_name'           => $item['policy_name'] ?? null,
                    'generate_permissions'  => $item['generate_permissions'] ?? 1,
                    'description'           => $item['description'] ?? null,
                    'server_side'           => $item['server_side'] ?? 0,
                    'details'               => $item['details'] ?? null,
                ])->save();
            }
        }
    }
}
