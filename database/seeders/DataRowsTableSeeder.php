<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Company;
use App\Gallery;
use App\Models\Gender;
use App\ImportPartner;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PartnerInstallment;
use App\Models\PaymentMethod;
use App\Photo;
use App\Models\Poll;
use App\Models\Product;
use App\Models\Project;
use App\Models\Promotion;
use App\Models\Publication;
use App\Pubrubric;
use App\Models\Region;
use App\Models\Rubric;
use App\Serrubric;
use App\Service;
use App\Models\ShippingMethod;
use App\Models\Shop;
use App\Models\Sticker;
use App\Models\Store;
use App\Models\User;
use App\Models\UserApplication;
use App\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Role;

class DataRowsTableSeeder extends StandardSeeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('data_rows')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $modules = config('cms.modules');
        foreach ($modules as $module => $allowed) {
            $method = Str::camel($module) . 'Rows';
            if ($allowed && method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    protected function usersRows()
    {
        $dataType = DataType::where('slug', 'users')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'nameRow',
            ],
            'email' => [
                'method' => 'emailRow',
            ],
            'phone_number' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.phone_number'),
                    'browse' => 1,
                ],
            ],
            'password' => [
                'method' => 'simpleRow',
                'data' => [
                    'type' => 'password',
                    'display_name' => __('seeders.data_rows.password'),
                    'required' => 1,
                    'browse' => 0,
                    'read' => 0,
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 0,
                    'order' => 4,
                    'details' => $this->string(),
                ],
            ],
            'remember_token' => [
                'method' => 'simpleRow',
                'data' => [
                    'type' => 'text',
                    'display_name' => __('seeders.data_rows.remember_token'),
                    'required' => 0,
                    'browse' => 0,
                    'read' => 0,
                    'edit' => 0,
                    'add' => 0,
                    'delete' => 0,
                    'order' => 5,
                ],
            ],
            'avatar' => [
                'method' => 'imageRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.avatar'),
                ],
            ],
            'role_id' => [
                'method' => 'simpleRow',
                'data' => [
                    'type' => 'text',
                    'display_name' => __('seeders.data_rows.role'),
                    'required' => 1,
                    'browse' => 0,
                    'read' => 0,
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'order' => 9,
                ],
            ],
            'user_belongsto_role_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.role'),
                    'browse' => 1,
                    'details' => $this->relationship(Role::class, 'roles', 'belongsTo', 'role_id', 'id', 'display_name', 'roles'),
                    'order' => 10,
                ],
            ],
            // 'user_belongstomany_role_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.roles_additional'),
            //         'browse' => 1,
            //         'details' => $this->relationship(Role::class, 'roles', 'belongsToMany', 'id', 'id', 'display_name', 'user_roles', 1),
            //         'order' => 11,
            //     ],
            // ],
            'settings' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.settings'),
                ],
            ],
            'first_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.first_name'),
                ],
            ],
            'last_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.last_name'),
                ],
            ],
            'middle_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.middle_name'),
                ],
            ],
            'address' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.address'),
                ],
            ],
            'email_verified_at' => [
                'method' => 'timestampRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.address'),
                    'browse'       => 0,
                    'read'         => 0,
                    'edit'         => 0,
                    'add'          => 0,
                    'delete'       => 0,
                ],
            ],
            'banned_until' => [
                'method' => 'hiddenRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function menusRows()
    {
        $dataType = DataType::where('slug', 'menus')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function rolesRows()
    {
        $dataType = DataType::where('slug', 'roles')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
            'display_name' => [
                'method' => 'simpleRow',
                'data' => [
                    'type' => 'text',
                    'display_name' => __('seeders.data_rows.display_name'),
                    'required' => 1,
                    'browse' => 1,
                    'read' => 1,
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'order' => 5,
                    'details' => $this->requiredString(),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function pagesRows()
    {
        $dataType = DataType::where('slug', 'pages')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType);
        $this->saveSeoRows($dataType);

        // specific rows
        $rows = [
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'short_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.short_name')
                ],
            ],
            'icon' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.icon')
                ],
            ],
            'images' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.images')
                ],
            ],
            'additional_info' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.additional_info')
                ],
            ],
            'file' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.file')
                ],
            ],
            'file_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.file_name')
                ],
            ],
            'views' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.views')
                ],
            ],
            // 'show_in' => [
            //     // 'method' => 'statusRow',
            //     'method' => 'hiddenRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.show_in_menu')
            //     ],
            // ],
            'show_in' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.show_in'),
                    'details' => $this->dropdown(Page::SHOW_IN_NONE, Page::showInPlaces())
                ],
            ],

            'order' => [
                'method' => 'orderRow',
            ],
            'parent_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.parent'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            // 'page_belongsto_parent_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.parent'),
            //         'details' => $this->relationship(Page::class, 'pages', 'belongsTo', 'parent_id', 'id', 'name'),
            //         'browse' => 1,
            //     ],
            // ],

            'background' => [
                'method' => 'hiddenRow',
            ],
            'seo_name' => [
                'method' => 'hiddenRow',
            ],
            'seo_body' => [
                'method' => 'hiddenRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function promotionsRows()
    {
        $dataType = DataType::where('slug', 'promotions')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Promotion::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'status' => [
                'method' => 'statusRow'
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.sort_order')
                ],
            ],
            'start_at' => [
                'method' => 'timestampRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.active_from'),
                ],
            ],
            'end_at' => [
                'method' => 'timestampRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.active_to'),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function bannersRows()
    {
        $dataType = DataType::where('slug', 'banners')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['slug', 'image', 'body']);

        // specific rows
        $rows = [
            'image' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.image'),
                ],
            ],
            'image_en' => [
                'method' => 'imageRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.image_en'),
                    'details' => $this->image(1400),
                ],
            ],
            'image_ru' => [
                'method' => 'imageRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.image_ru'),
                    'details' => $this->image(1400),
                ],
            ],
            'image_uz' => [
                'method' => 'imageRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.image_uz'),
                    'details' => $this->image(1400),
                ],
            ],
            'type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.banner_type'),
                    'order' => 1,
                    'details' => $this->dropdown('slide', Banner::types()),
                    'browse' => 1,
                ],
            ],
            'text_color' => [
                'method' => 'colorRow',
                'data' => [
                    'display_name' => 'Цвет текста',
                ],
            ],
            'description_top' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => 'Верхнее короткое описание',
                ],
            ],
            'description_bottom' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => 'Нижнее короткое описание',
                ],
            ],
            'button_text' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.button_text'),
                ],
            ],
            'url' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.url'),
                ],
            ],
            // 'active_from' => [
            //     'method' => 'timestampRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.active_from'),
            //     ],
            // ],
            // 'active_to' => [
            //     'method' => 'timestampRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.active_to'),
            //     ],
            // ],
            'active_from' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.active_from'),
                ],
            ],
            'active_to' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.active_to'),
                ],
            ],
            'timer' => [
                'method' => 'hiddenRow',
            ],
            'shop_id' => [
                'method' => 'hiddenRow',
            ],
            'language' => [
                'method' => 'hiddenRow',
            ],
            'category_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.category'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'product_belongsto_category_relationship' => [
                'method' => 'relationshipRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.category'),
                    'details' => $this->relationship(Category::class, 'categories', 'belongsTo', 'category_id', 'id', 'full_name'),
                    'browse' => 1,
                ],
            ],
            'image_mobile' => [
                'method' => 'hiddenRow',
            ],
            'order' => [
                'method' => 'orderRow',
            ],

            'targetable_type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => 'Цель',
                    'details' => $this->dropdown('-', Banner::targetTypes()),
                    'browse' => 1,
                    'read' => 1,
                ],
            ],
            'targetable_id' => [
                'method' => 'numberRow',
                'data' => [
                    'display_name' => 'ID цели',
                    'browse'       => 1,
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function categoriesRows()
    {
        $dataType = DataType::where('slug', 'categories')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Category::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            // 'parent_id' => [
            //     'method' => 'parentIdRow',
            // ],

            'parent_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.parent'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'category_belongsto_parent_relationship' => [
                'method' => 'relationshipRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.parent'),
                    'details' => $this->relationship(Category::class, 'categories', 'belongsTo', 'parent_id', 'id', 'full_name'),
                ],
            ],

            'gender_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.gender'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            // 'category_belongsto_gender_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.gender'),
            //         'details' => $this->relationship(Gender::class, 'genders', 'belongsTo', 'gender_id', 'id', 'name'),
            //     ],
            // ],

            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            'icon' => [
                'method' => 'hiddenRow',
            ],
            // 'icon' => [
            //     'method' => 'imageRow',
            //     'data' => [
            //         'display_name' => 'Иконка',
            //         'details' => $this->image(1000, [
            //             [
            //                 'name' => 'micro',
            //                 'width' => 24,
            //                 'height' => 24,
            //             ],
            //         ]),
            //     ],
            // ],
            // 'featured' => [
            //     'method' => 'statusRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.featured')
            //     ],
            // ],
            'show_in' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.show_in'),
                    'details' => $this->dropdown(Category::SHOW_IN_MENU, Category::showInPlaces())
                ],
            ],
            'order' => [
                'method' => 'orderRow',
            ],
            'svg_icon' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => 'SVG иконка',
                    'details'      => $this->string(50000),
                ],
            ],
            'h1_name' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'H1 name',
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function brandsRows()
    {
        $dataType = DataType::where('slug', 'brands')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Brand::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            'is_featured' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.featured'),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function projectsRows()
    {
        $dataType = DataType::where('slug', 'projects')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Project::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            'type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' =>'Type',
                    'details' => $this->dropdown(Project::TYPE_COMMON, Project::types()),
                ],
            ],
            'h1_name' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'H1 name',
                ],
            ],
            'project_belongstomany_product_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_types.product.plural'),
                    'details' => $this->relationship(Product::class, 'products', 'belongsToMany', 'id', 'id', 'name', 'product_project', 1),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function stickersRows()
    {
        $dataType = DataType::where('slug', 'stickers')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image', 'slug', 'body']);

        $imageThumbs = [];
        foreach (Sticker::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'order' => [
                'method' => 'orderRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function paymentMethodsRows()
    {
        $dataType = DataType::where('slug', 'payment_methods')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image', 'slug', 'body']);

        $imageThumbs = [];
        foreach (PaymentMethod::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'code' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'Код',
                ],
            ],
            'app' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => 'Для приложения',
                ],
            ],
            'desktop' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => 'Для десктопа',
                ],
            ],
            'installment' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => 'Метод оплаты для рассрочки',
                ],
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'order' => [
                'method' => 'orderRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function shippingMethodsRows()
    {
        $dataType = DataType::where('slug', 'shipping_methods')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image', 'slug', 'body']);

        $imageThumbs = [];
        foreach (ShippingMethod::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'code' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'Код',
                ],
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'order' => [
                'method' => 'orderRow',
            ],
            'price' => [
                'method' => 'priceRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.price'),
                ],
            ],
            'order_min_price' => [
                'method' => 'priceRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.order_min_price'),
                ],
            ],
            'order_max_price' => [
                'method' => 'priceRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.order_max_price'),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function partnersRows()
    {
        $dataType = DataType::where('slug', 'partners')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image', 'slug', 'body']);

        $imageThumbs = [];
        foreach (Partner::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'order' => [
                'method' => 'orderRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function productGroupsRows()
    {
        $dataType = DataType::where('slug', 'product_groups')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image', 'slug', 'body', 'description', 'status']);
        $rows = [
            'unique_code' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.unique_code'),
                ],
            ],
            'product_group_belongstomany_attribute_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.attributes'),
                    'details' => $this->relationship(Attribute::class, 'attributes', 'belongsToMany', 'id', 'id', 'name', 'attribute_product_group', 1),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function partnerInstallmentsRows()
    {
        $dataType = DataType::where('slug', 'partner_installments')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'partner_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.partner'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'details' => $this->required(),
                ],
            ],
            'partner_installment_belongsto_partner_relationship' => [
                'method' => 'relationshipRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.partner'),
                    'details' => $this->relationship(Partner::class, 'partners', 'belongsTo', 'partner_id', 'id', 'name'),
                    'browse' => 1,
                    'read' => 1,
                ],
            ],

            'duration' => [
                'method' => 'requiredNumberRow',
                'data' => [
                    'display_name' => 'Месяцы',
                ],
            ],
            'percent' => [
                'method' => 'requiredNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.margin_percentage'),
                    'browse' => 1,
                ],
            ],
            'min_price' => [
                'method' => 'priceRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.min_price'),
                ],
            ],
            'max_price' => [
                'method' => 'priceRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.max_price'),
                ],
            ],

            'status' => [
                'method' => 'statusRow',
            ],

            'order' => [
                'method' => 'orderRow',
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function importPartnersRows()
    {
        $dataType = DataType::where('slug', 'import_partners')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image', 'slug', 'body', 'status']);

        $imageThumbs = [];
        foreach (Partner::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'status' => [
                'method' => 'hiddenNumberRow',
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function importPartnerMarginsRows()
    {
        $dataType = DataType::where('slug', 'import_partner_margins')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'import_partner_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.import_partner'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'details' => $this->required(),
                ],
            ],
            'import_partner_margin_belongsto_import_partner_relationship' => [
                'method' => 'relationshipRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.import_partner'),
                    'details' => $this->relationship(ImportPartner::class, 'import_partners', 'belongsTo', 'import_partner_id', 'id', 'name'),
                    'browse' => 1,
                    'read' => 1,
                ],
            ],

            'percent' => [
                'method' => 'requiredNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.margin_percentage'),
                    'browse' => 1,
                ],
            ],
            'from' => [
                'method' => 'priceRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.price_from'),
                ],
            ],
            'to' => [
                'method' => 'priceRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.price_to'),
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function gendersRows()
    {
        $dataType = DataType::where('slug', 'genders')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function productsRows()
    {
        $dataType = DataType::where('slug', 'products')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image', 'body']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Product::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [

            'sku' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.sku'),
                    'browse' => 1,
                ],
            ],
            'barcode' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.barcode'),
                    'browse' => 0,
                ],
            ],
            'external_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => 'External ID',
                    'browse' => 0,
                ],
            ],
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            // 'product_belongsto_user_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.user'),
            //         'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id'),
            //     ],
            // ],
            'category_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.category'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            // 'product_belongsto_category_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.category'),
            //         'details' => $this->relationship(Category::class, 'categories', 'belongsTo', 'category_id', 'id', 'full_name'),
            //     ],
            // ],
            'product_belongstomany_category_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.category'),
                    'details' => $this->relationship(Category::class, 'categories', 'belongsToMany', 'id', 'id', 'full_name', 'category_product', 1),
                ],
            ],
            // 'product_belongstomany_sticker_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_types.sticker.plural'),
            //         'details' => $this->relationship(Sticker::class, 'stickers', 'belongsToMany', 'id', 'id', 'name', 'product_sticker', 1),
            //     ],
            // ],
            'shop_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.shop'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            // 'product_belongsto_shop_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.shop'),
            //         'details' => $this->relationship(Shop::class, 'shops', 'belongsTo', 'shop_id', 'id', 'full_name'),
            //     ],
            // ],
            // 'product_belongstomany_category_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_types.category.plural'),
            //         'details' => $this->relationship(Category::class, 'categories', 'belongsToMany', 'id', 'id', 'full_name', 'category_product', 1),
            //     ],
            // ],
            // 'product_belongstomany_company_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_types.company.plural'),
            //         'details' => $this->relationship(Company::class, 'companies', 'belongsToMany', 'id', 'id', 'name', 'company_product', 1),
            //     ],
            // ],

            'brand_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.brand'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            // 'product_belongsto_brand_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.brand'),
            //         'details' => $this->relationship(Brand::class, 'brands', 'belongsTo', 'brand_id'),
            //     ],
            // ],
            'status' => [
                'method' => 'statusDropdownRow',
            ],
            'body' => [
                'method' => 'bodyRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.description'),
                    'required' => 0,
                ],
            ],
            'specifications' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.specifications'),
                    'required' => 0,
                ],
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.gallery'),
                ],
            ],
            // 'images' => [
            //     'method' => 'imageRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.gallery'),
            //         'type' => 'multiple_images',
            //         'details' => $this->image(1000, $imageThumbs),
            //     ],
            // ],
            'in_stock' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.in_stock'),
                ],
            ],
            // 'in_stock' => [
            //     'method' => 'numberRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.in_stock'),
            //         'browse' => 0,
            //     ],
            // ],
            // 'unit_of_measurement' => [
            //     'method' => 'hiddenRow',
            // ],
            // 'popular' => [
            //     'method' => 'hiddenNumberRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.schedule'),
            //     ],
            // ],
            'is_bestseller' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.bestseller'),
                ],
            ],
            'is_featured' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.featured'),
                ],
            ],
            'is_new' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.new_product'),
                ],
            ],
            'is_promotion' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.promotion'),
                ],
            ],
            'installment_price' => [
                // 'method' => 'priceRow',
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.installment_price'),
                    'browse' => 0,
                ],
            ],
            'price' => [
                'method' => 'priceRow',
                'data' => [
                    'browse' => 0,
                ],
            ],
            'sale_price' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.sale_price'),
                    'browse' => 0,
                ],
            ],

            // 'unique_code' => [
            //     'method' => 'uniqueRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.unique_code'),
            //         'details' => $this->unique('products', 'unique_code'),
            //     ],
            // ],

            // 'price_cost' => [
            //     'method' => 'hiddenNumberRow',
            // ],
            // 'is_special' => [
            //     'method' => 'statusRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.is_special'),
            //     ],
            // ],
            // 'discount' => [
            //     'method' => 'hiddenNumberRow',
            // ],
            // 'discount' => [
            //     'method' => 'numberRow',
            //     'data'   => [
            //         'display_name' => __('seeders.data_rows.discount'),
            //         'details' => $this->number(0, 100),
            //     ],
            // ],
            // 'price_special' => [
            //     'method' => 'hiddenNumberRow',
            //     'data'   => [],
            // ],
            // 'type' => [
            //     'method' => 'hiddenNumberRow',
            //     'data'   => [],
            // ],
            'min_price_per_month' => [
                'method' => 'hiddenNumberRow',
            ],
            'views' => [
                'method' => 'hiddenNumberRow',
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
            ],
            'rating' => [
                'method' => 'hiddenNumberRow',
            ],
            'source' => [
                'method' => 'hiddenNumberRow',
            ],
            'gender' => [
                'method' => 'hiddenRow',
            ],
            'age_group' => [
                'method' => 'hiddenRow',
            ],
            'h1_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => 'H1 name',
                ],
            ],
            'product_group_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.product_group'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function brandCategoryTextsRows()
    {
        $dataType = DataType::where('slug', 'brand_category_texts')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['slug', 'image', 'status']);
        $this->saveSeoRows($dataType);

        // specific rows
        $rows = [
            'category_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.category'),
                    'details' => $this->required(),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'brand_category_text_belongsto_category_relationship' => [
                'method' => 'relationshipRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.category'),
                    'details' => $this->relationship(Category::class, 'categories', 'belongsTo', 'category_id', 'id', 'full_name'),
                ],
            ],
            'brand_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.brand'),
                    'details' => $this->required(),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'brand_category_text_belongsto_brand_relationship' => [
                'method' => 'relationshipRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.brand'),
                    'details' => $this->relationship(Brand::class, 'brands', 'belongsTo', 'brand_id'),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'h1_name' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'H1 name',
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function attributesRows()
    {
        $dataType = DataType::where('slug', 'attributes')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
            'slug' => [
                'method' => 'slugRow',
                'data' => [
                    'details' => $this->slug(),
                ],
            ],
            // 'type' => [
            //     'method' => 'hiddenRow',
            // ],
            'type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.attribute_type'),
                    'details' => $this->dropdown(Attribute::TYPE_SELECT, Attribute::types()),
                ],
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
            ],
            'used_for_filter' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.used_for_filter'),
                    'details'      => $this->checkbox(null, null, null, 'Отметьте, если этот атрибут нужно отображать на странице категории товаров.'),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function productAttributesTemplatesRows()
    {
        $dataType = DataType::where('slug', 'product_attributes_templates')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
            'body' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.body'),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function attributeValuesRows()
    {
        $dataType = DataType::where('slug', 'attribute_values')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
            'slug' => [
                'method' => 'slugRow',
                'data' => [
                    'details' => $this->slug(),
                ],
            ],
            'attribute_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.attribute'),
                    'details' => $this->required(),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'attribute_value_belongsto_attribute_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.attribute'),
                    'details' => $this->relationship(Attribute::class, 'attributes', 'belongsTo', 'attribute_id'),
                    'browse' => 1,
                ],
            ],
            'color' => [
                'method' => 'colorRow',
                'data' => [
                    'display_name' => 'Цвет',
                ],
            ],
            'is_light_color' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => 'Светлый цвет?',
                ],
            ],
            'image' => [
                'method' => 'hiddenRow',
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
            ],
            'used_for_filter' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.used_for_filter'),
                    'details'      => $this->checkbox('Yes', 'No', false, 'Отметьте, если это значение нужно отображать на странице категории товаров.'),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function articlesRows()
    {
        $dataType = DataType::where('slug', 'articles')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType);
        $this->saveSeoRows($dataType);
    }

    protected function specializationsRows()
    {
        $dataType = DataType::where('slug', 'specializations')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType);
        $this->saveSeoRows($dataType);

        // specific rows
        $rows = [
            'schedule' => [
                'method' => 'bodyRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.schedule'),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function specialistsRows()
    {
        $dataType = DataType::where('slug', 'specialists')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['name', 'slug']);
        $this->saveSeoRows($dataType);

        // specific rows
        $rows = [
            'first_name' => [
                'method' => 'nameRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.first_name')
                ],
            ],
            'last_name' => [
                'method' => 'nameRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.last_name')
                ],
            ],
            'middle_name' => [
                'method' => 'nameRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.middle_name'),
                    'details' => $this->string()
                ],
            ],
            'position' => [
                'method' => 'nameRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.position')
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function audiosRows()
    {
        $dataType = DataType::where('slug', 'audios')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType);
        $this->saveSeoRows($dataType);

        // specific rows
        $rows = [
            'audio_mp3' => [
                'method' => 'fileRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.audio_mp3'),
                    'order' => 11,
                    'details' => $this->file(['mp3'], false),
                ],
            ],
            'audio_ogg' => [
                'method' => 'fileRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.audio_ogg'),
                    'order' => 12,
                    'details' => $this->file(['ogg'], false),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function newsRows()
    {
        $dataType = DataType::where('slug', 'news')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType);
        $this->saveSeoRows($dataType);

        // specific rows
        $rows = [
            'youtube_code' => [
                'method' => 'descriptionRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.youtube_code'),
                    'order' => 10,
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function videosRows()
    {
        $dataType = DataType::where('slug', 'videos')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType);
        $this->saveSeoRows($dataType);

        // specific rows
        $rows = [
            'youtube_code' => [
                'method' => 'descriptionRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.youtube_code'),
                    'order' => 10,
                ],
            ],
            'video_mp4' => [
                'method' => 'fileRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.video_mp4'),
                    'order' => 11,
                    'details' => $this->file(['mp4'], false),
                ],
            ],
            'video_webm' => [
                'method' => 'fileRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.video_webm'),
                    'order' => 12,
                    'details' => $this->file(['webm'], false),
                ],
            ],
            'video_ogv' => [
                'method' => 'fileRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.video_ogv'),
                    'order' => 13,
                    'details' => $this->file(['ogv'], false),
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function staticTextsRows()
    {
        $dataType = DataType::where('slug', 'static_texts')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
            'key' => [
                'method' => 'nameRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.access_key'),
                    'details' => [
                        'validation' => [
                            'rule' => 'required|unique:static_texts,key|max:191',
                        ],
                    ],
                ],
            ],
            'description' => [
                'method' => 'descriptionRow',
                'data' => [
                    'details' => $this->string(60000),
                ],
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, [], 100),
                ],
            ],
            'url' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'URL',
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function rubricsRows()
    {
        $dataType = DataType::where('slug', 'rubrics')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image']);
        $this->saveSeoRows($dataType);
        $rows = [
            'parent_id' => [
                'method' => 'parentIdRow',
            ],
            'status' => [
                'method' => 'statusRow'
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function pubrubricsRows()
    {
        $dataType = DataType::where('slug', 'pubrubrics')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image']);
        $this->saveSeoRows($dataType);
        $rows = [
            'parent_id' => [
                'method' => 'parentIdRow',
            ],
            'status' => [
                'method' => 'statusRow'
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function serrubricsRows()
    {
        $dataType = DataType::where('slug', 'serrubrics')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image']);
        $this->saveSeoRows($dataType); // specific rows
        $rows = [
            'parent_id' => [
                'method' => 'parentIdRow',
            ],
            'status' => [
                'method' => 'statusRow'
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function companiesRows()
    {
        $dataType = DataType::where('slug', 'companies')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Company::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'company_belongstomany_rubric_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_types.rubric.plural'),
                    'details' => $this->relationship(Rubric::class, 'rubrics', 'belongsToMany', 'id', 'id', 'full_name', 'company_rubric', 1),
                ],
            ],
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'company_belongsto_user_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id', 'id', 'email', 'users'),
                    'order' => 10,
                ],
            ],
            'region_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.region'),
                ],
            ],
            'status' => [
                'method' => 'statusRow'
            ],
            'type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.subscription_type'),
                    'details' => $this->dropdown(0, [
                        '1' => 'VIP',
                        '0' => 'Обычная',
                    ]),
                ],
            ],
            'business_form' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.business_form'),
                ],
            ],
            'brand_name' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.brand_name'),
                ],
            ],
            'logo' => [
                'method' => 'imageRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.logo'),
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'image' => [
                'method' => 'hiddenRow',
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            // 'images' => [
            //     'method' => 'imageRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.gallery'),
            //         'type' => 'multiple_images',
            //     ],
            // ],
            'featured' => [
                'method' => 'hiddenNumberRow',
                //'method' => 'statusRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.featured'),
                ],
            ],
            'email' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.email'),
                ],
            ],
            'phone' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.phone'),
                ],
            ],
            'fax' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.fax'),
                ],
            ],
            'site' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.site'),
                ],
            ],
            'address' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.address'),
                ],
            ],
            'landmark' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.landmark'),
                ],
            ],
            'transport' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.transport'),
                ],
            ],
            'work_hours' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.work_hours'),
                ],
            ],
            'map' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.map_code'),
                    'details' => $this->image(1000),
                ],
            ],
            'map_image' => [
                'method' => 'imageRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.map_image'),
                    'details' => $this->image(1000),
                ],
            ],
            'latitude' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.latitude'),
                ],
            ],
            'longitude' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.longitude'),
                ],
            ],
            'inn' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.inn'),
                ],
            ],
            'contract' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.contract'),
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function publicationsRows()
    {
        $dataType = DataType::where('slug', 'publications')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Publication::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'page_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_types.page.singular'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            // 'publication_belongsto_user_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.user'),
            //         'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id'),
            //     ],
            // ],
            // 'company_id' => [
            //     'method' => 'hiddenRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.company'),
            //         'edit' => 1,
            //         'add' => 1,
            //         'delete' => 1,
            //     ],
            // ],
            // 'publication_belongsto_company_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.company'),
            //         'details' => $this->relationship(Company::class, 'companies', 'belongsTo', 'company_id'),
            //     ],
            // ],
            // 'pubrubric_id' => [
            //     'method' => 'hiddenRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.rubric'),
            //         // 'details' => $this->required(),
            //         'edit' => 1,
            //         'add' => 1,
            //         'delete' => 1,
            //     ],
            // ],
            // 'publication_belongsto_pubrubric_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.rubric'),
            //         'details' => $this->relationship(Pubrubric::class, 'pubrubrics', 'belongsTo', 'pubrubric_id', 'id', 'full_name'),
            //     ],
            // ],
            'author' => [
                'method' => 'hiddenRow',
            ],
            'status' => [
                'method' => 'statusRow'
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            'featured' => [
                'method' => 'hiddenRow',
            ],
            'type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.publication_type'),
                    'details' => $this->dropdown(Publication::TYPE_NEWS, Publication::types()),
                    'browse' => 1,
                ],
            ],
            'views' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.views_counter'),
                ],
            ],
            'short_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.short_name')
                ],
            ],
            'additional_info' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.additional_info')
                ],
            ],
            'video_code' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.video_code')
                ],
            ],
            'file' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.file')
                ],
            ],
            'file_name' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.file_name')
                ],
            ],
            'icon' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.icon')
                ],
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.sort_order')
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function notificationsRows()
    {
        $dataType = DataType::where('slug', 'notifications')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'notification_belongsto_user_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id', 'id', 'email'),
                ],
            ],
            // 'status' => [
            //     'method' => 'statusRow',
            //     'data' => [
            //         'display_name' => 'Прочитано',
            //     ],
            // ],
            'status' => [
                'method' => 'hiddenNumberRow',
                'data' => [
                    'display_name' => 'Прочитано',
                ],
            ],
            'subject' => [
                'method' => 'hiddenRow',
            ],
            'message' => [
                'method' => 'textAreaRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function warehousesRows()
    {
        $dataType = DataType::where('slug', 'warehouses')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'region_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.region'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'warehouse_belongsto_region_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.region'),
                    'details' => $this->relationship(Region::class, 'regions', 'belongsTo', 'region_id', 'id', 'name'),
                    'browse' => 1,
                ],
            ],
            'name' => [
                'method' => 'titleRow',
                'data' => [
                    'display_name' => 'Название',
                ],
            ],
            'code' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'Код',
                    'details' => $this->required(),
                    'browse' => 1,
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function subscribersRows()
    {
        $dataType = DataType::where('slug', 'subscribers')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.name'),
                    'browse' => 1,
                ],
            ],
            'email' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.email'),
                    'browse' => 1,
                ],
            ],
            'status' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => 'Подписка активна',
                ],
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function servicesRows()
    {
        $dataType = DataType::where('slug', 'services')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['status', 'image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Service::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'service_belongsto_user_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id'),
                ],
            ],
            'company_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'service_belongsto_company_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'details' => $this->relationship(Company::class, 'companies', 'belongsTo', 'company_id'),
                ],
            ],
            'serrubric_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.rubric'),
                    'details' => $this->required(),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'service_belongsto_serrubric_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.rubric'),
                    'details' => $this->relationship(Serrubric::class, 'serrubrics', 'belongsTo', 'serrubric_id', 'id', 'full_name'),
                ],
            ],
            'status' => [
                'method' => 'statusRow'
            ],
            'price' => [
                'method' => 'priceRow',
            ],
            'price_from' => [
                'method' => 'hiddenNumberRow',
            ],
            'price_to' => [
                'method' => 'hiddenNumberRow',
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            'featured' => [
                'method' => 'hiddenRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function pricelistsRows()
    {
        $dataType = DataType::where('slug', 'pricelists')->firstOrFail();

        $this->saveMainRows($dataType);
        $rows = [
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                ],
            ],
            // 'vacancy_belongsto_user_relationship' => [
            //     'method' => 'relationshipRow',
            //     'data' => [
            //         'display_name' => __('seeders.data_rows.user'),
            //         'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id', 'id', 'name', 'users'),
            //         'order' => 10,
            //     ],
            // ],
            'company_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                ],
            ],
            'pricelist_belongsto_company_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'details' => $this->relationship(Company::class, 'companies', 'belongsTo', 'company_id', 'id', 'name', 'companies'),
                    'order' => 10,
                    'browse' => 1,
                    'read' => 1,
                    'edit' => 0,
                    'add' => 0,
                    'delete' => 0,
                ],
            ],
            'name' => [
                'method' => 'hiddenRow',
            ],
            'process_info' => [
                'method' => 'hiddenRow',
            ],
            'process_status' => [
                'method' => 'hiddenRow',
            ],
            'file' => [
                'method' => 'fileRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.file'),
                    'details' => $this->file(['xlsx'], false),
                    'browse' => 1,
                    'read' => 1,
                ],
            ],
            'status' => [
                'method' => 'statusRow'
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function cVSRows()
    {
        $dataType = DataType::where('slug', 'c_v_s')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['slug', 'image', 'status']);
        $this->saveSeoRows($dataType);

        $rows = [
            'c_v_belongsto_user_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id', 'id', 'name', 'users'),
                    'order' => 10,
                ],
            ],
            'salary_from' => [
                'method' => 'numberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.salary_from'),
                ],
            ],
            'salary_to' => [
                'method' => 'numberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.salary_to'),
                ],
            ],
            'file' => [
                'method' => 'fileRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.c_v_pdf_file'),
                    'details' => $this->file(['pdf', 'docx'], false),
                ],
            ],
            'status' => [
                'method' => 'statusRow'
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function vacanciesRows()
    {
        $dataType = DataType::where('slug', 'vacancies')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['slug', 'image', 'status']);
        $this->saveSeoRows($dataType);

        $vacancyTypes = array_combine(Vacancy::$types, Vacancy::$types);
        $rows = [
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'vacancy_belongsto_user_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id', 'id', 'name', 'users'),
                    'order' => 10,
                ],
            ],
            'company_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'vacancy_belongsto_company_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'details' => $this->relationship(Company::class, 'companies', 'belongsTo', 'company_id', 'id', 'name', 'companies'),
                    'order' => 10,
                ],
            ],
            'salary_from' => [
                'method' => 'numberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.salary_from'),
                ],
            ],
            'salary_to' => [
                'method' => 'numberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.salary_to'),
                ],
            ],
            'type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.type'),
                    'details' => $this->dropdown(array_values($vacancyTypes)[0], $vacancyTypes),
                ],
            ],
            'status' => [
                'method' => 'statusRow'
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function galleriesRows()
    {
        $dataType = DataType::where('slug', 'galleries')->firstOrFail();

        $this->saveMainRows($dataType);

        $rows = [
            'name' => [
                'method' => 'titleRow',
            ],
            'company_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'required' => 1,
                    'details' => $this->required(),
                ],
            ],
            'gallery_belongsto_company_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'details' => $this->relationship(Company::class, 'companies', 'belongsTo', 'company_id', 'id', 'name', 'companies'),
                    'order' => 10,
                    'required' => 1,
                ],
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
            ],
            'status' => [
                'method' => 'statusRow'
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function photosRows()
    {
        $dataType = DataType::where('slug', 'photos')->firstOrFail();

        $this->saveMainRows($dataType);

        $imageThumbs = [];
        foreach (Photo::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        $rows = [
            'gallery_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.gallery'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'details' => $this->required(),
                ],
            ],
            'photo_belongsto_gallery_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.gallery'),
                    'details' => $this->relationship(Gallery::class, 'galleries', 'belongsTo', 'gallery_id', 'id', 'name', 'galleries'),
                    'order' => 10,
                ],
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                    'browse' => 1,
                ],
            ],
            'order' => [
                'method' => 'hiddenNumberRow',
            ],
            'status' => [
                'method' => 'statusRow',
            ],
        ];
        $this->saveRows($dataType, $rows);
    }

    protected function ordersRows()
    {
        $dataType = DataType::where('slug', 'orders')->firstOrFail();

        // specific rows
        $rows = [
            'id' => [
                'method' => 'idRow',
                'data' => [
                    'browse' => 1,
                ],
            ],
            'created_at' => [
                'method' => 'createdAtRow',
            ],
            'updated_at' => [
                'method' => 'updatedAtRow',
            ],
            'user_id' => [
                'method' => 'hiddenRow',
            ],
            'address_id' => [
                'method' => 'hiddenRow',
            ],
            'shipping_method_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => 'Метод доставки',
                ],
            ],
            'payment_method_id' => [
                'method' => 'hiddenRow',
            ],
            'name' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.name'),
                    'required' => 1,
                    'browse' => 1,
                ],
            ],
            'phone_number' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.phone_number'),
                    'required' => 1,
                    'browse' => 1,
                ],
            ],
            'email' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.email'),
                ],
            ],
            'address_line_1' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.address'),
                    'required' => 1,
                ],
            ],
            'message' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.message'),
                    'required' => 1,
                ],
            ],
            'subtotal' => [
                'method' => 'hiddenRow',
            ],
            'total' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.total'),
                    'browse' => 1,
                    'read' => 1,
                    'edit' => 0,
                    'add' => 0,
                    'delete' => 0,
                ],
            ],
            'shipping_price' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => 'Доставка',
                    'browse' => 1,
                    'read' => 1,
                    'edit' => 0,
                    'add' => 0,
                    'delete' => 0,
                ],
            ],
            'conditions' => [
                'method' => 'hiddenRow',
            ],
            'status' => [
                'method' => 'dropdownRow',
                'data' => [
                    'details' => $this->dropdown(Order::STATUS_PENDING, Order::statuses(), ['no_change_status_buttons' => 1]),
                    'display_name' => 'Статус',
                    'required' => 1,
                    'browse' => 1,
                ],
            ],
            'ip_address' => [
                'method' => 'hiddenRow',
            ],
            'user_agent' => [
                'method' => 'hiddenRow',
            ],
            'communication_method' => [
                'method' => 'dropdownRow',
                'data' => [
                    'details' => $this->dropdown(Order::COMMUNICATION_METHOD_PHONE, Order::communicationMethods()),
                    'display_name' => 'Метод общения',
                    'required' => 1,
                ],
            ],
            'type' => [
                'method' => 'hiddenRow',
            ],
            'latitude' => [
                'method' => 'hiddenRow',
            ],
            'longitude' => [
                'method' => 'hiddenRow',
            ],
            'location_accuracy' => [
                'method' => 'hiddenRow',
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function reviewsRows()
    {
        $dataType = DataType::where('slug', 'reviews')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'name' => [
                'method' => 'nameRow',
                'browse' => 1,
            ],
            'email' => [
                'method' => 'emailRow',
            ],
            'body' => [
                // 'method' => 'bodyRow',
                'method' => 'descriptionRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.message'),
                    'required' => 1,
                    'browse' => 1,
                ],
            ],
            'rating' => [
                'method' => 'tinyNumberRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.mark'),
                ],
            ],
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'review_belongsto_user_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id', 'id', 'name', 'users'),
                    'order' => 10,
                ],
            ],
            'status' => [
                'method' => 'statusDropdownRow'
            ],
            'reviewable_id' => [
                'method' => 'hiddenRow',
            ],
            'reviewable_type' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.type'),
                    'browse' => 1,
                    'read' => 1,
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function redirectsRows()
    {
        $dataType = DataType::where('slug', 'redirects')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'from' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.old_url'),
                    'required' => 1,
                    'browse' => 1,
                ],
            ],
            'to' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.new_url'),
                    'required' => 1,
                    'browse' => 1,
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function userApplicationsRows()
    {
        $dataType = DataType::where('slug', 'user_applications')->firstOrFail();

        $this->saveMainRows($dataType, [], ['id']);

        // specific rows
        $rows = [
            'id' => [
                'method' => 'idRow',
                'data' => [
                    'browse' => 1,
                    'read' => 1,
                ],
            ],
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => 'Пользователь',
                    'browse' => 1,
                    'read' => 1,
                ],
            ],
            'status' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => 'Статус',
                    'details' => $this->dropdown(UserApplication::STATUS_PENDING, UserApplication::statuses()),
                    'browse' => 1,
                    'read' => 1,
                ],
            ],
            'type' => [
                'method' => 'dropdownRow',
                'data' => [
                    'display_name' => 'Тип',
                    'details' => $this->dropdown(UserApplication::TYPE_BECOME_SELLER, UserApplication::types()),
                    'browse' => 1,
                    'read' => 1,
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function shopsRows()
    {
        $dataType = DataType::where('slug', 'shops')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image', 'status']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Shop::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'user_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'product_belongsto_user_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.user'),
                    'details' => $this->relationship(User::class, 'users', 'belongsTo', 'user_id', 'id', 'phone_number'),
                    'browse' => 1
                ],
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'email' => [
                'method' => 'emailRow',
                'data' => [
                    'browse' => 0,
                ]
            ],
            'phone_number' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.phone'),
                ],
            ],
            'address' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.address'),
                ],
            ],
            'status' => [
                'method' => 'statusDropdownRow',
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function storesRows()
    {
        $dataType = DataType::where('slug', 'stores')->firstOrFail();

        $this->saveMainRows($dataType);
        $this->saveStandardRows($dataType, [], ['image']);
        $this->saveSeoRows($dataType);

        $imageThumbs = [];
        foreach (Store::$imgSizes as $key => $value) {
            $imageThumbs[] = [
                'name' => $key,
                'width' => $value[0],
                'height' => $value[1],
            ];
        }

        // specific rows
        $rows = [
            'parent_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.parent'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1000, $imageThumbs),
                ],
            ],
            'background' => [
                'method' => 'hiddenRow',
            ],
            'images' => [
                'method' => 'hiddenRow',
            ],
            'email' => [
                'method' => 'emailRow',
                'data' => [
                    'browse' => 0,
                ]
            ],
            'phone_number' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.phone'),
                ],
            ],
            'work_hours' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.work_hours'),
                ],
            ],
            'address' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.address'),
                ],
            ],
            'landmark' => [
                'method' => 'textRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.landmark'),
                ],
            ],
            'map_code' => [
                'method' => 'textAreaRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.map_code'),
                ],
            ],
            'order' => [
                'method' => 'orderRow',
            ],
            'latitude' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.latitude'),
                ],
            ],
            'longitude' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.longitude'),
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function pollsRows()
    {
        $dataType = DataType::where('slug', 'polls')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [
            'question' => [
                'method' => 'textRow',
                'data' => [
                    'browse' => 1,
                    'display_name' => 'Вопрос',
                ],
            ],
            'description' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => 'Описание',
                ],
            ],
            'status' => [
                'method' => 'statusRow',
                'data' => [
                    'display_name' => 'Опрос активен?',
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function pollAnswersRows()
    {
        $dataType = DataType::where('slug', 'poll_answers')->firstOrFail();

        $this->saveMainRows($dataType);

        // specific rows
        $rows = [

            'poll_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_types.poll.singular'),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'poll_answer_belongsto_poll_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'display_name' => __('seeders.data_types.poll.singular'),
                    'details' => $this->relationship(Poll::class, 'polls', 'belongsTo', 'poll_id', 'id', 'question'),
                    'order' => 10,
                ],
            ],
            'answer' => [
                'method' => 'textRow',
                'data' => [
                    'browse' => 1,
                    'display_name' => 'Вариант ответа',
                ],
            ],
            'color' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => 'Цвет',
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    protected function fixedCompaniesRows()
    {
        $dataType = DataType::where('slug', 'fixed_companies')->firstOrFail();

        $this->saveMainRows($dataType);
        // specific rows
        $rows = [
            'company_id' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.company'),
                    'details' => $this->required(),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'fixed_company_belongsto_company_relationship' => [
                'method' => 'relationshipRow',
                'data' => [
                    'browse' => 1,
                    'display_name' => __('seeders.data_rows.company'),
                    'details' => $this->relationship(Company::class, 'companies', 'belongsTo', 'company_id'),
                ],
            ],
            'rubric_id' => [
                'method' => 'hiddenRow',
                'data'   => [
                    'display_name' => __('seeders.data_rows.rubric'),
                    'details' => $this->required(),
                    'edit' => 1,
                    'add' => 1,
                    'delete' => 1,
                ],
            ],
            'fixed_company_belongsto_rubric_relationship' => [
                'method' => 'relationshipRow',
                'data'   => [
                    'browse' => 1,
                    'display_name' => __('seeders.data_rows.rubric'),
                    'details' => $this->relationship(Rubric::class, 'rubrics', 'belongsTo', 'rubric_id'),
                ],
            ],
            'order' => [
                'method' => 'orderRow',
            ],
            'start_at' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.start_at'),
                ],
            ],
            'end_at' => [
                'method' => 'hiddenRow',
                'data' => [
                    'display_name' => __('seeders.data_rows.end_at'),
                ],
            ],
        ];

        $this->saveRows($dataType, $rows);
    }

    /**
     * Get row or create.
     *
     * @param [type] $type  [description]
     * @param [type] $field [description]
     *
     * @return [type] [description]
     */
    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field' => $field,
        ]);
    }

    /*
     *
     * Save one row
     *
     * */
    protected function saveRow($type, $field, $methodName, $data = [])
    {
        $dataRow = $this->dataRow($type, $field);
        if (!$dataRow->exists) {
            // if (isset($data['details']) && is_array($data['details'])) {
            //     $data['details'] = json_encode($data['details'], JSON_FORCE_OBJECT);
            // }
            $dataRow->fill($this->$methodName($data))->save();
        }
    }

    /*
     *
     * Save given rows
     *
     * */
    protected function saveRows($type, array $rows, array $excluded = [])
    {
        foreach ($excluded as $excludedField) {
            if (array_key_exists($excludedField, $rows)) {
                unset($rows[$excludedField]);
            }
        }
        foreach ($rows as $key => $value) {
            if (!isset($value['data'])) {
                $value['data'] = [];
            }
            $this->saveRow($type, $key, $value['method'], $value['data']);
        }
    }

    /*
     *
     * Common rows methods
     *
     * */
    protected function saveMainRows($type, array $customRows = [], array $excluded = [])
    {
        $rows = array_merge([
            'id' => [
                'method' => 'idRow',
            ],
            'created_at' => [
                'method' => 'createdAtRow',
            ],
            'updated_at' => [
                'method' => 'updatedAtRow',
            ],
        ], $customRows);
        $this->saveRows($type, $rows, $excluded);
    }

    protected function saveStandardRows($type, array $customRows = [], array $excluded = [])
    {
        $rows = array_merge([
            'name' => [
                'method' => 'titleRow',
            ],
            'slug' => [
                'method' => 'slugRow',
                'data' => [
                    'details' => $this->slug(),
                ],
            ],
            'description' => [
                'method' => 'descriptionRow',
            ],
            'body' => [
                'method' => 'bodyRow',
            ],
            'image' => [
                'method' => 'imageRow',
                'data' => [
                    'details' => $this->image(1400, [
                        [
                            'name' => 'medium',
                            'width' => '310',
                            'height' => '185',
                        ],
                    ]),
                ],
            ],
            'status' => [
                'method' => 'statusRow',
            ],
        ], $customRows);
        $this->saveRows($type, $rows, $excluded);
    }

    protected function saveSeoRows($type, array $customRows = [], array $excluded = [])
    {
        $rows = array_merge([
            'seo_title' => [
                'method' => 'seoTitleRow',
            ],
            'meta_description' => [
                'method' => 'metaDescriptionRow',
            ],
            'meta_keywords' => [
                'method' => 'metaKeywordsRow',
            ],
        ], $customRows);
        $this->saveRows($type, $rows, $excluded);
    }
}
