<?php

namespace Database\Seeders;

use App\Models\StaticText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticTextsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('static_texts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // for ($i = 1; $i <= 4; $i++) {
        //     StaticText::factory()->create([
        //         'key' => 'footer_text_' . $i,
        //     ]);
        // }

        // home page text
        StaticText::factory()->create([
            'name' => 'LET’S MANUFACTURE A BETTER FUTURE!',
            'description' => 'WE HAVE EVERYTHING TO BUILD YOUR DREAM',
            'key' => 'home_page_text',
            'image' => 'static_texts/hero.jpg',
        ]);

        // no_products_text
        StaticText::factory()->create([
            'name' => 'No products text',
            'description' => 'No products',
            'key' => 'no_products_text',
        ]);

        // 404
        StaticText::factory()->create([
            'name' => '404',
            'description' => 'Page not found',
            'key' => '404_page',
            'image' => 'static_texts/404-img.png',
        ]);

        // footer description
        StaticText::factory()->create([
            'name' => 'Footer description',
            'description' => 'TevaGlass is a young manufacturing company. And we are proud that in a short period of time, the company has achieved recognition both in Uzbekistan and abroad.',
            'key' => 'footer_description',
        ]);

        // advantages
        StaticText::factory()->create([
            'name' => 'A team of specialists',
            'description' => 'Only people with many years of experience work in our team and they undoubtedly know what the quality and reliability of the product are. ',
            'key' => 'advantage_1',
            'image' => 'static_texts/advantage-01.png'
        ]);
        StaticText::factory()->create([
            'name' => 'A team of specialists',
            'description' => 'Only people with many years of experience work in our team and they undoubtedly know what the quality and reliability of the product are. ',
            'key' => 'advantage_2',
            'image' => 'static_texts/advantage-02.png'
        ]);
        StaticText::factory()->create([
            'name' => 'A team of specialists',
            'description' => 'Only people with many years of experience work in our team and they undoubtedly know what the quality and reliability of the product are. ',
            'key' => 'advantage_3',
            'image' => 'static_texts/advantage-03.png'
        ]);

        // principles
        StaticText::factory()->create([
            'name' => '+10',
            'description' => 'Representative offices',
            'key' => 'principle_1',
            'image' => 'static_texts/principle-01.png',
            'url' => '#',
        ]);
        StaticText::factory()->create([
            'name' => '+10',
            'description' => 'Representative offices',
            'key' => 'principle_2',
            'image' => 'static_texts/principle-02.png',
            'url' => '#',
        ]);
        StaticText::factory()->create([
            'name' => '+10',
            'description' => 'Representative offices',
            'key' => 'principle_3',
            'image' => 'static_texts/principle-03.png',
            'url' => '#',
        ]);
        StaticText::factory()->create([
            'name' => '+10',
            'description' => 'Representative offices',
            'key' => 'principle_4',
            'image' => 'static_texts/principle-04.png',
            'url' => '#',
        ]);

        // steps
        // StaticText::factory()->create([
        //     'name' => 'Шаг 1',
        //     'description' => 'Описание',
        //     'key' => 'step_1',
        //     'image' => 'static_texts/step-01.png'
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Шаг 2',
        //     'description' => 'Описание',
        //     'key' => 'step_2',
        //     'image' => 'static_texts/step-02.png'
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Шаг 3',
        //     'description' => 'Описание',
        //     'key' => 'step_3',
        //     'image' => 'static_texts/step-03.png'
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Шаг 4',
        //     'description' => 'Описание',
        //     'key' => 'step_4',
        //     'image' => 'static_texts/step-04.png'
        // ]);

        StaticText::factory()->create([
            'name' => 'Address',
            'key' => 'contact_address',
            'description' => 'Proplast USA 1330 Livingston Ave North Brunswick, NJ 08902',
        ]);

        StaticText::factory()->create([
            'name' => 'Work hours',
            'key' => 'work_hours',
            'description' => 'Mon-Fri: 9:00 - 18:00',
        ]);

        // StaticText::factory()->create([
        //     'name' => 'Доставка (страница товара)',
        //     'key' => 'delivery_text',
        //     'description' => 'Описание ...',
        // ]);

        // StaticText::factory()->create([
        //     'name' => 'Бесплатная доставка (страница товара)',
        //     'key' => 'free_delivery_text',
        //     'description' => 'Бесплатная <a href="/page/7-dostavka">доставка</a> по Ташкенту',
        // ]);

        // StaticText::factory()->create([
        //     'name' => 'Способы получения (страница товара)',
        //     'key' => 'receive_methods_text',
        //     'description' => 'Способы получения: самовывоз, <a href="/page/7-dostavka">доставка</a>',
        // ]);

        // StaticText::factory()->create([
        //     'name' => 'Оплата (страница товара)',
        //     'key' => 'payment_text',
        //     'description' => 'Описание ...',
        // ]);

        // StaticText::factory()->create([
        //     'name' => 'Гарантия (страница товара)',
        //     'key' => 'guarantee_text',
        //     'description' => 'Описание ...',
        // ]);

        /*
        StaticText::factory()->create([
            'name' => 'Zoodpay payment description',
            'key' => 'zoodpay_payment_description',
            'description' => 'Рассрочка - 4 платежа',
        ]);

        StaticText::factory()->create([
            'name' => 'Zoodpay payment terms and conditions',
            'key' => 'zoodpay_payment_terms_and_conditions',
            'description' => '<b>Условия обслуживания</b><br>\r\n• Услуга ZoodPay дает возможность оплатить покупку, поделив общую сумму платежа на 4 части в течение 90 дней, без учета процентов и без комиссий. <br>\r\n• Вы должны быть старше 18 лет и быть авторизованным владельцем банковской карты для подачи заявки.<br>\r\n• Все заказы подлежат подтверждению системой. При наличии у Вас просроченных платежей, услуга ZoodPay будет недоступна.<br>\r\n• ZoodPay автоматически удержит сумму платежа с Вашей карты согласно графику. Если платеж не будет обработан в установленный срок, к Вам будет применён штраф за просрочку в размере 7 долларов США.<br>\r\n• В случае невозможности своевременной оплаты, просим связаться с нами незамедлительно.<br>\r\n• Продавец несет ответственность за доставку, качество товара и за осуществление возврата.\r\n<br><br>\r\n<b>ВАЖНАЯ ИНФОРМАЦИЯ О ПРЕДВАРИТЕЛЬНОЙ АВТОРИЗАЦИИ КАРТЫ:</b><br>\r\nВ рамках процесса утверждения и оценки Вашей возможности выполнения своих обязательств по услуге ZoodPay в соответствии с графиком платежей, мы оставляем за собой право провести предварительную авторизацию Вашего заявленного источника платежей. \r\nЭта процедура может включать в себя блокировку средств на счете, каждый раз, когда вы совершаете онлайн-покупку или добавляете новую карту в свою учетную запись ZoodPay.   <br>\r\nДля онлайн-покупок мы немедленно уведомим банк о необходимости аннулирования транзакций предварительной авторизации. В течение этого процесса ZoodPay не удерживает никаких средств. Мы не можем гарантировать сроки, необходимые Вашему банку для обработки этого действия и предоставления ваших средств.\r\n<br><br>\r\nУсловия использования и доступ к нашим Услугам. <br>\r\n1.1 Стороны настоящего соглашения<br>\r\nНастоящее Соглашение является договором между Вами («Вы» или «Ваш») и ZoodPay LLC OrientSwiss («ZoodPay», «мы», «наш»).  <br>\r\n\r\n1.2.  Правила настоящего соглашения<br>\r\nПри несогласии с условиями данного Соглашения, Вам не следует совершать покупки с использованием Сервиса ZoodPay.<br>\r\nПрежде чем воспользоваться какой-либо нашей услугой, Вам необходимо ознакомиться с настоящим Соглашением, а также с Политикой конфиденциальности ZoodPay и другими правилами на сайте / мобильном приложении, которые включены в настоящее Соглашение посредством ссылки.<br>\r\nМы рекомендуем Вам сохранить копию этого соглашения (включая все правила). <br><br>\r\n\r\n\r\n2. Обязанности сторон<br>\r\n2.1 ZoodPay позволяет Вам покупать (a) товары или услуги, предлагаемые онлайн-продавцами, включая зарубежных продавцов, рекомендованных ZoodPay,  (б) а также приобретать товары у сторонних поставщиков.<br>\r\n2.2 Размещая Заказ у Продавца и используя наши услуги, Вы предоставляете нам безоговорочное согласие на проведение нами оплаты товара/услуги от Вашего имени в обмен на Ваше согласие и обязательство погасить оплаченную нами сумму или оплатить нам в соответствии с настоящим соглашением согласованные суммы (которые могут включать любые применимые налоги, пошлины или другие связанные суммы, взимаемые Продавцом) и в сроки, указанные в Вашем Графике платежей, а также любые дополнительные применимые сборы, включая поздние сборы если Вы пропустите возврат в запланированный срок.<br>\r\n2.3 Размещая Заказ через наши услуги на товары от третьих лиц, Вы соглашаетесь вернуть или оплатить нам назначенные суммы в соответствии с настоящим Соглашением, которые могут включать любые применимые налоги или сборы, взимаемые Сторонним поставщиком, и в сроки, указанные в Вашем Графике платежей, а также любые дополнительные применимые сборы, включая поздние сборы, если вы пропустите платеж в назначенный день.<br>\r\n2.4 Вы признаете, что мы не контролируем и не несем ответственности за продукты или услуги, приобретенные у Продавцов, оплаченных с помощью ZoodPay. Мы не можем гарантировать, что Продавец, у которого Вы совершаете покупку, выполнит все свои обязательства.<br>\r\n2.5 Вы признаете, что мы действуем в качестве агента для Сторонних поставщиков, когда мы обрабатываем Заказы на Сторонние товары. Доставка, выполнение и поддержка клиентов для Сторонних Товаров будет обеспечиваться Сторонним Поставщиком. Вы соглашаетесь соблюдать условия и положения Стороннего поставщика, указанного Вами на момент покупки. Пожалуйста, ознакомьтесь со всеми применимыми условиями Стороннего поставщика.',
        ]);
        */

        /*// footer text
        StaticText::factory()->create([
            'name' => 'Footer Text 1',
            'key' => 'footer_text_1',
            'description' => '',
        ]);
        StaticText::factory()->create([
            'name' => 'Footer Text 2',
            'key' => 'footer_text_2',
            'description' => '',
        ]);
        StaticText::factory()->create([
            'name' => 'Footer Text 3',
            'key' => 'footer_text_3',
            'description' => 'Все права защищены.',
        ]);
        StaticText::factory()->create([
            'name' => 'Footer Text 4',
            'key' => 'footer_text_4',
            'description' => 'Копирование материалов с сайта без согласования с администрацией ресурса запрещено',
        ]);

        // add items text
        StaticText::factory()->create([
            'name' => 'Текст "Добавить товар" на странице категории. Шаблоны: {category_name}',
            'key' => 'add_product_text',
            'description' => 'Добавить товар {category_name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Текст "Добавить компанию" на странице рубрики компаний. Шаблоны: {rubric_name}',
            'key' => 'add_company_text',
            'description' => 'Добавить компанию {rubric_name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Текст "Добавить услугу" на странице рубрики услуг. Шаблоны: {rubric_name}',
            'key' => 'add_service_text',
            'description' => 'Добавить услугу {rubric_name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Текст "Добавить публикацию" на странице рубрики публикации. Шаблоны: {rubric_name}',
            'key' => 'add_publication_text',
            'description' => 'Добавить публикацию {rubric_name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Текст "Добавить вакансию" на странице вакансии.',
            'key' => 'add_vacancy_text',
            'description' => 'Добавить вакансию',
        ]);
        StaticText::factory()->create([
            'name' => 'Текст "Добавить резюме" на странице резюме.',
            'key' => 'add_cv_text',
            'description' => 'Добавить резюме',
        ]);

        */

        // SEO meta text Product
        // StaticText::factory()->create([
        //     'name' => 'Meta title товара. Шаблоны: {name}, {price}, {brand_name}, {year}',
        //     'key' => 'seo_template_product_seo_title',
        //     'description' => 'Product meta title {name}, {price}, {brand_name}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta description товара. Шаблоны: {name}, {price}, {brand_name}, {year}',
        //     'key' => 'seo_template_product_meta_description',
        //     'description' => 'Product meta description {name}, {price}, {brand_name}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta keywords товара. Шаблоны: {name}, {price}, {brand_name}, {year}',
        //     'key' => 'seo_template_product_meta_keywords',
        //     'description' => 'Product meta keywords {name}, {price}, {brand_name}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'H1 товара. Шаблоны: {name}, {price}, {brand_name}, {year}',
        //     'key' => 'seo_template_product_h1_name',
        //     'description' => 'Product page h1 text {name}, {price}, {brand_name}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Короткое описание товара. Шаблоны: {name}, {price}, {brand_name}, {year}',
        //     'key' => 'seo_template_product_description',
        //     'description' => 'Product page description text {name}, {price}, {brand_name}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Полное описание товара. Шаблоны: {name}, {price}, {brand_name}, {year}',
        //     'key' => 'seo_template_product_body',
        //     'description' => 'Product page body text {name}, {price}, {brand_name}, {year}',
        // ]);

        // SEO meta text Brand
        // StaticText::factory()->create([
        //     'name' => 'Meta title бренда. Шаблоны: {name}, {products_quantity}, {year}',
        //     'key' => 'seo_template_brand_seo_title',
        //     'description' => 'Brand meta title {name}, {products_quantity}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta description бренда. Шаблоны: {name}, {products_quantity}, {year}',
        //     'key' => 'seo_template_brand_meta_description',
        //     'description' => 'Brand meta description {name}, {products_quantity}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta keywords бренда. Шаблоны: {name}, {products_quantity}, {year}',
        //     'key' => 'seo_template_brand_meta_keywords',
        //     'description' => 'Brand meta keywords {name}, {products_quantity}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'H1 бренда. Шаблоны: {name}, {products_quantity}, {year}',
        //     'key' => 'seo_template_brand_h1_name',
        //     'description' => 'Brand page h1 text {name}, {products_quantity}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Короткое описание бренда. Шаблоны: {name}, {products_quantity}, {year}',
        //     'key' => 'seo_template_brand_description',
        //     'description' => 'Brand page description text {name}, {products_quantity}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Полное описание бренда. Шаблоны: {name}, {products_quantity}, {year}',
        //     'key' => 'seo_template_brand_body',
        //     'description' => 'Brand page body text {name}, {products_quantity}, {year}',
        // ]);

        // SEO meta text Category
        // StaticText::factory()->create([
        //     'name' => 'Meta title категории. Шаблоны: {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_category_seo_title',
        //     'description' => 'Category meta title {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta description категории. Шаблоны: {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_category_meta_description',
        //     'description' => 'Category meta description {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta keywords категории. Шаблоны: {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_category_meta_keywords',
        //     'description' => 'Category meta keywords {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'H1 категории. Шаблоны: {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_category_h1_name',
        //     'description' => 'Category page h1 text {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Короткое описание категории. Шаблоны: {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_category_description',
        //     'description' => 'Category page description text {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Полное описание категории. Шаблоны: {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_category_body',
        //     'description' => 'Category page body text {name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);

        // SEO meta text Brand Category
        // StaticText::factory()->create([
        //     'name' => 'Meta title категории бренда. Шаблоны: {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_brand_category_seo_title',
        //     'description' => 'Brand category meta title {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta description категории бренда. Шаблоны: {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_brand_category_meta_description',
        //     'description' => 'Brand category meta description {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Meta keywords категории бренда. Шаблоны: {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_brand_category_meta_keywords',
        //     'description' => 'Brand category meta keywords {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'H1 категории бренда. Шаблоны: {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_brand_category_h1_name',
        //     'description' => 'Brand category page h1 text {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Короткое описание категории бренда. Шаблоны: {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_brand_category_description',
        //     'description' => 'Brand category page description text {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);
        // StaticText::factory()->create([
        //     'name' => 'Полное описание категории бренда. Шаблоны: {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        //     'key' => 'seo_template_brand_category_body',
        //     'description' => 'Brand category page body text {brand_name}, {category_name}, {products_quantity}, {min_price}, {max_price}, {year}',
        // ]);

        /*

        // SEO meta text Company
        StaticText::factory()->create([
            'name' => 'Meta title компании. Шаблоны: {name}',
            'key' => 'seo_template_company_seo_title',
            'description' => 'Company meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description компании. Шаблоны: {name}',
            'key' => 'seo_template_company_meta_description',
            'description' => 'Company meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords компании. Шаблоны: {name}',
            'key' => 'seo_template_company_meta_keywords',
            'description' => 'Company meta keywords {name}',
        ]);

        // SEO meta text Rubric
        StaticText::factory()->create([
            'name' => 'Meta title рубрики компании. Шаблоны: {name}',
            'key' => 'seo_template_rubric_seo_title',
            'description' => 'Rubric meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description рубрики компании. Шаблоны: {name}',
            'key' => 'seo_template_rubric_meta_description',
            'description' => 'Rubric meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords рубрики компании. Шаблоны: {name}',
            'key' => 'seo_template_rubric_meta_keywords',
            'description' => 'Rubric meta keywords {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Короткое описание рубрики компании. Шаблоны: {name}',
            'key' => 'seo_template_rubric_description',
            'description' => 'Rubric page description text {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Полное описание рубрики компании. Шаблоны: {name}',
            'key' => 'seo_template_rubric_body',
            'description' => 'Rubric page body text {name}',
        ]);

        // SEO meta text Service
        StaticText::factory()->create([
            'name' => 'Meta title услуги. Шаблоны: {name}',
            'key' => 'seo_template_service_seo_title',
            'description' => 'Service meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description услуги. Шаблоны: {name}',
            'key' => 'seo_template_service_meta_description',
            'description' => 'Service meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords услуги. Шаблоны: {name}',
            'key' => 'seo_template_service_meta_keywords',
            'description' => 'Service meta keywords {name}',
        ]);

        // SEO meta text Serrubric
        StaticText::factory()->create([
            'name' => 'Meta title рубрики услуг. Шаблоны: {name}',
            'key' => 'seo_template_serrubric_seo_title',
            'description' => 'Serrubric meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description рубрики услуг. Шаблоны: {name}',
            'key' => 'seo_template_serrubric_meta_description',
            'description' => 'Serrubric meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords рубрики услуг. Шаблоны: {name}',
            'key' => 'seo_template_serrubric_meta_keywords',
            'description' => 'Serrubric meta keywords {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Короткое описание рубрики услуг. Шаблоны: {name}',
            'key' => 'seo_template_serrubric_description',
            'description' => 'Serrubric page description text {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Полное описание рубрики услуг. Шаблоны: {name}',
            'key' => 'seo_template_serrubric_body',
            'description' => 'Serrubric page body text {name}',
        ]);

        // SEO meta text Publication
        StaticText::factory()->create([
            'name' => 'Meta title публикации. Шаблоны: {name}',
            'key' => 'seo_template_publication_seo_title',
            'description' => 'Publication meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description публикации. Шаблоны: {name}',
            'key' => 'seo_template_publication_meta_description',
            'description' => 'Publication meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords публикации. Шаблоны: {name}',
            'key' => 'seo_template_publication_meta_keywords',
            'description' => 'Publication meta keywords {name}',
        ]);

        // SEO meta text Pubrubric
        StaticText::factory()->create([
            'name' => 'Meta title рубрики публикаций. Шаблоны: {name}',
            'key' => 'seo_template_pubrubric_seo_title',
            'description' => 'Pubrubric meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description рубрики публикаций. Шаблоны: {name}',
            'key' => 'seo_template_pubrubric_meta_description',
            'description' => 'Pubrubric meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords рубрики публикаций. Шаблоны: {name}',
            'key' => 'seo_template_pubrubric_meta_keywords',
            'description' => 'Pubrubric meta keywords {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Короткое описание рубрики публикаций. Шаблоны: {name}',
            'key' => 'seo_template_pubrubric_description',
            'description' => 'Pubrubric page description text {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Полное описание рубрики публикаций. Шаблоны: {name}',
            'key' => 'seo_template_pubrubric_body',
            'description' => 'Pubrubric page body text {name}',
        ]);

        // SEO meta text Vacancy
        StaticText::factory()->create([
            'name' => 'Meta title вакансии. Шаблоны: {name}',
            'key' => 'seo_template_vacancy_seo_title',
            'description' => 'Vacancy meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description вакансии. Шаблоны: {name}',
            'key' => 'seo_template_vacancy_meta_description',
            'description' => 'Vacancy meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords вакансии. Шаблоны: {name}',
            'key' => 'seo_template_vacancy_meta_keywords',
            'description' => 'Vacancy meta keywords {name}',
        ]);

        // SEO meta text
        StaticText::factory()->create([
            'name' => 'Meta title резюме. Шаблоны: {name}',
            'key' => 'seo_template_cv_seo_title',
            'description' => 'CV meta title {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta description резюме. Шаблоны: {name}',
            'key' => 'seo_template_cv_meta_description',
            'description' => 'CV meta description {name}',
        ]);
        StaticText::factory()->create([
            'name' => 'Meta keywords резюме. Шаблоны: {name}',
            'key' => 'seo_template_cv_meta_keywords',
            'description' => 'CV meta keywords {name}',
        ]);
        */
    }
}
