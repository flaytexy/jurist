<?php

namespace app\modules\park\controllers\backend;

use app\modules\attachment\models\Attachment;
use app\modules\park\models\Attribute;
use app\modules\park\models\AttributeTranslation;
use app\modules\park\models\AttributeValue;
use app\modules\park\models\AttributeValueTranslation;
use app\modules\park\models\Brand;
use app\modules\park\models\BrandTranslation;
use app\modules\park\models\CarImage;
use app\modules\park\models\CarPrices;
use app\modules\park\models\CarTranslation;
use app\modules\park\models\Category;
use app\modules\park\models\CategoryTranslation;
use app\modules\park\models\City;
use app\modules\park\models\CityTranslation;
use app\modules\park\models\ModelTranslation;
use GuzzleHttp\Exception\BadResponseException;
use Yii;
use app\models\Language;
use app\modules\park\models\Car;
use yii\base\Model;
use app\modules\park\models\Model as CarModel;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;

class CarController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Автомобили – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionImport()
    {
        if (Yii::$app->request->isPost) {
            if($file = UploadedFile::getInstanceByName('import')) {
                if (($handle = fopen($file->tempName, 'r')) !== false) {
                    $statistics = [
                        'car_created' => 0,
                        'car_updated' => 0,
                        'brand_created' => 0,
                        'model_created' => 0,
                        'category_created' => 0,
                        'attribute_created' => 0,
                        'attribute_value_created' => 0,
                        'city_created' => 0,
                    ];

                    CarPrices::updateAll(
                        [
                            'price_1' => 0,
                            'price_3' => 0,
                            'price_6' => 0,
                            'price_8' => 0,
                            'price_15' => 0,
                            'price_29' => 0,
                        ]
                    );
                    CarTranslation::updateAll(
                        [
                            'equipment' => '',
                        ]
                    );

                    /*$car_attributes = [];

                    foreach (['Количество мест', 'Привод', 'Тип двигателя', 'Кузов', 'C кондиционером', 'Трансмиссия'] as $attribute) {
                        // Attribute
                        $model_attribute_translation = AttributeTranslation::find()->where(['title' => $attribute])->one();

                        if ($model_attribute_translation) {
                            $model_attribute = Attribute::findOne($model_attribute_translation->attribute_id);
                        } else {
                            $model_attribute = new Attribute;

                            $model_attribute->save();

                            $statistics['attribute_created']++;

                            foreach (Language::getLanguages() as $language) {
                                $translation_model = new AttributeTranslation;
                                $translation_model->loadDefaultValues();

                                $translation_model->attribute_id = $model_attribute->id;

                                $translation_model->language = $language['local'];

                                if ($translation_model->language == 'ru-RU') {
                                    $translation_model->title = $attribute;
                                    $translation_model->status = AttributeTranslation::STATUS_PUBLISHED;
                                } else {
                                    $translation_model->status = AttributeTranslation::STATUS_DRAFT;
                                }

                                $translation_model->save(false);
                            }
                        }

                        $car_attributes[$attribute] = $model_attribute;
                    }*/

                    while (($data = fgetcsv($handle)) !== false) {
                        if ($price_id = (int)$data[0]) {
                            $model = Car::find()->where(['price_id' => $price_id])->one();

                            if (!$model) {
                                $model = new Car;
                                $model->price_id = $price_id;
                            }

                        }

                        if (isset($model)) {
                            $car_info = [
                                'brand' => trim($data[1]), // Марка
                                'model' => trim($data[2]), // Модель
                                'category' => trim($data[3]), // Класс
                                'acriss' => trim($data[4]), // ACRISS
                                'deposit' => trim($data[13]), // Залог

                                'attr_capacity' => trim($data[7]), // Объем двигателя
                                'attr_fuel' => trim($data[9]), // Расход топлива л/100 км
                                'attr_seat' => trim($data[5]), // Количество мест
                                'attr_rear_drive' => trim($data[6]), // Привод
                                'attr_engine' => trim($data[8]), // Тип двигателя
                                'attr_body' => trim($data[10]), // Кузов
                                'attr_conditioner' => trim($data[11]), // C кондиционером
                                'attr_transmission' => trim($data[12]), // Трансмиссия
                            ];

                            if (array_filter($car_info)) {

                                // Brand
                                $model_brand_translation = BrandTranslation::find()->where(['title' => $car_info['brand']])->one();

                                if ($model_brand_translation) {
                                    $model_brand = Brand::findOne($model_brand_translation->brand_id);
                                } else {
                                    $model_brand = new Brand;

                                    $model_brand->save();

                                    $statistics['brand_created']++;

                                    foreach (Language::getLanguages() as $language) {
                                        $translation_model = new BrandTranslation;
                                        $translation_model->loadDefaultValues();

                                        $translation_model->brand_id = $model_brand->id;

                                        $translation_model->language = $language['local'];

                                        if ($translation_model->language == 'ru-RU') {
                                            $translation_model->title = $car_info['brand'];
                                            $translation_model->slug = Inflector::slug($car_info['brand']);
                                            $translation_model->status = BrandTranslation::STATUS_PUBLISHED;
                                        } else {
                                            $translation_model->status = BrandTranslation::STATUS_DRAFT;
                                        }

                                        $translation_model->save(false);
                                    }
                                }

                                // Model
                                $model_model_translation = ModelTranslation::find()
                                    ->where([
                                        CarModel::tableName() . '.brand_id' => $model_brand->id,
                                        ModelTranslation::tableName() . '.title' => $car_info['model'],
                                    ])
                                    ->innerJoinWith('model')
                                    ->one();

                                if ($model_model_translation) {
                                    $model_model = CarModel::findOne($model_model_translation->model_id);
                                } else {
                                    $model_model = new CarModel;
                                    $model_model->brand_id = $model_brand->id;
                                    $model_model->save();

                                    $statistics['model_created']++;

                                    foreach (Language::getLanguages() as $language) {
                                        $translation_model = new ModelTranslation;
                                        $translation_model->loadDefaultValues();

                                        $translation_model->model_id = $model_model->id;

                                        $translation_model->language = $language['local'];

                                        if ($translation_model->language == 'ru-RU') {
                                            $translation_model->title = $car_info['model'];
                                            $translation_model->slug = Inflector::slug($car_info['model']);
                                            $translation_model->status = ModelTranslation::STATUS_PUBLISHED;
                                        } else {
                                            $translation_model->status = ModelTranslation::STATUS_DRAFT;
                                        }

                                        $translation_model->save(false);
                                    }
                                }

                                // Category
                                $model_category_translation = CategoryTranslation::find()->where(['title' => $car_info['category']])->one();

                                if ($model_category_translation) {
                                    $model_category = Category::findOne($model_category_translation->category_id);
                                } else {
                                    $model_category = new Category;

                                    $model_category->save();

                                    $statistics['category_created']++;

                                    foreach (Language::getLanguages() as $language) {
                                        $translation_model = new CategoryTranslation;
                                        $translation_model->loadDefaultValues();

                                        $translation_model->category_id = $model_category->id;

                                        $translation_model->language = $language['local'];

                                        if ($translation_model->language == 'ru-RU') {
                                            $translation_model->title = $car_info['category'];
                                            $translation_model->slug = Inflector::slug($car_info['category']);
                                            $translation_model->status = CategoryTranslation::STATUS_PUBLISHED;
                                        } else {
                                            $translation_model->status = CategoryTranslation::STATUS_DRAFT;
                                        }

                                        $translation_model->save(false);
                                    }
                                }

                                $model->setAttributes([
                                    'sticker_id' => $model->sticker_id ?: null,
                                    'brand_id' => $model_brand->id,
                                    'model_id' => $model_model->id,
                                    'category_id' => $model_category->id,
                                    'acriss' => $car_info['acriss'],
                                    'deposit' => str_replace(',', '.', $car_info['deposit']),

                                    'attr_capacity' => str_replace(',', '.', $car_info['attr_capacity']),
                                    'attr_fuel' => str_replace(',', '.', $car_info['attr_fuel']),
                                    'attr_seat' => $car_info['attr_seat'],
                                    'attr_rear_drive' => $car_info['attr_rear_drive'],
                                    'attr_engine' => $car_info['attr_engine'],
                                    'attr_body' => $car_info['attr_body'],
                                    'attr_conditioner' => $car_info['attr_conditioner'],
                                    'attr_transmission' => $car_info['attr_transmission'],
                                ]);

                                if ($model->isNewRecord) {
                                    $statistics['car_created']++;
                                } else {
                                    $statistics['car_updated']++;
                                }

                                $model->save(false);

                                if (!$model->translations) {
                                    foreach (Language::getLanguages() as $language) {
                                        $translation_model = new CarTranslation;
                                        $translation_model->loadDefaultValues();

                                        $translation_model->car_id = $model->id;
                                        $translation_model->language = $language['local'];
                                        $translation_model->status = CarTranslation::STATUS_DRAFT;

                                        $translation_model->save(false);
                                    }
                                }

//                                $car_attribute_info = [
//                                    'Количество мест' => trim($data[5]), // Количество мест
//                                    'Привод' => trim($data[6]), // Привод
//                                    'Тип двигателя' => trim($data[8]), // Тип двигателя
//                                    'Кузов' => trim($data[10]), // Кузов
//                                    'C кондиционером' => trim($data[11]), // C кондиционером
//                                    'Трансмиссия' => trim($data[12]), // Трансмиссия
//                                ];
//
//                                if ($car_attribute_info) {
//                                    foreach ($car_attribute_info as $attribute => $attribute_value) {
//                                        $model_attribute = $car_attributes[$attribute];
//
//                                        // Attribute value
//                                        $model_attribute_value_translation = AttributeValueTranslation::find()
//                                            ->where([
//                                                AttributeValue::tableName() . '.attribute_id' => $model_attribute->id,
//                                                AttributeValueTranslation::tableName() . '.title' => $attribute_value,
//                                            ])
//                                            ->innerJoinWith('attributeValue')
//                                            ->one();
//
//                                        if ($model_attribute_value_translation) {
//                                            $model_attribute_value = AttributeValue::findOne($model_attribute_value_translation->attribute_value_id);
//                                        } else {
//                                            $model_attribute_value = new AttributeValue;
//                                            $model_attribute_value->attribute_id = $model_attribute->id;
//                                            $model_attribute_value->save();
//
//                                            $statistics['attribute_value_created']++;
//
//                                            foreach (Language::getLanguages() as $language) {
//                                                $translation_model = new AttributeValueTranslation;
//                                                $translation_model->loadDefaultValues();
//
//                                                $translation_model->attribute_value_id = $model_attribute_value->id;
//
//                                                $translation_model->language = $language['local'];
//
//                                                if ($translation_model->language == 'ru-RU') {
//                                                    $translation_model->title = $attribute_value;
//                                                    $translation_model->slug = Inflector::slug($attribute_value);
//                                                    $translation_model->status = ModelTranslation::STATUS_PUBLISHED;
//                                                } else {
//                                                    $translation_model->status = ModelTranslation::STATUS_DRAFT;
//                                                }
//
//                                                $translation_model->save(false);
//                                            }
//                                        }
//
//                                        $model->unlink('attributeValues', $model_attribute_value, true);
//                                        $model->link('attributeValues', $model_attribute_value);
//                                    }
//                                }
                            }

                            if (!$model->isNewRecord) {

                                $equipment = [
                                    'ru-RU' => trim($data[14]), // Комплектация - RU
                                    'en-US' => trim($data[15]), // Комплектация - EN
                                    'uk-UA' => trim($data[16]), // Комплектация - UA
                                ];

                                foreach ($model->translations as $equipment_language => $equipment_translation) {
                                    if (isset($equipment[$equipment_language]) && $equipment[$equipment_language]) {
                                        $stored_equipment = array_filter(array_map('trim', explode(',', $equipment_translation->equipment)));

                                        array_push($stored_equipment, $equipment[$equipment_language]);

                                        $stored_equipment = implode(', ', $stored_equipment);

                                        $equipment_translation->equipment = $stored_equipment;
                                        $equipment_translation->save(false);
                                    }
                                }

                                $price_info = [
                                    trim($data[17]), // Тип цены (город или услуга)
                                    trim($data[18]), // 1 - 2
                                    trim($data[19]), // 3 - 5
                                    trim($data[20]), // 6 = 7
                                    trim($data[21]), // 8 - 14
                                    trim($data[22]), // 15 - 28
                                    trim($data[23]), // 29+
                                ];

                                $city = array_shift($price_info);

                                if ($city && count(array_filter($price_info)) == 6) {
                                    if (in_array($city, ['Суперстраховка 50', 'Суперстраховка 100', 'Ассистанс'])) {
                                        $price = null;

                                        switch ($city) {
                                            case 'Суперстраховка 50':
                                                $price = $model->insurance50;
                                                break;
                                            case 'Суперстраховка 100':
                                                $price = $model->insurance100;
                                                break;
                                            case 'Ассистанс':
                                                $price = $model->assistance;
                                                break;
                                        }

                                        if ($price) {
                                            $price->setAttributes([
                                                'price_1' => $price_info[0],
                                                'price_3' => $price_info[1],
                                                'price_6' => $price_info[2],
                                                'price_8' => $price_info[3],
                                                'price_15' => $price_info[4],
                                                'price_29' => $price_info[5],
                                            ]);

                                            $price->save(false);
                                        }
                                    } else {

                                        // City
                                        $model_city_translation = CityTranslation::find()->where(['title' => $city])->one();

                                        if ($model_city_translation) {
                                            $model_city = City::findOne($model_city_translation->city_id);
                                        } else {
                                            $model_city = new City;
                                            $model_city->phones = serialize([]);
                                            $model_city->save(false);

                                            $statistics['city_created']++;

                                            foreach (Language::getLanguages() as $language) {
                                                $translation_model = new CityTranslation;
                                                $translation_model->loadDefaultValues();

                                                $translation_model->city_id = $model_city->id;

                                                $translation_model->language = $language['local'];

                                                if ($translation_model->language == 'ru-RU') {
                                                    $translation_model->title = $city;
                                                    $translation_model->slug = Inflector::slug($city);
                                                    $translation_model->status = CityTranslation::STATUS_PUBLISHED;
                                                } else {
                                                    $translation_model->status = CityTranslation::STATUS_DRAFT;
                                                }

                                                $translation_model->save(false);
                                            }
                                        }

                                        $price = $model->getCity($model_city->id);

                                        if ($price) {
                                            $price->setAttributes([
                                                'price_1' => $price_info[0],
                                                'price_3' => $price_info[1],
                                                'price_6' => $price_info[2],
                                                'price_8' => $price_info[3],
                                                'price_15' => $price_info[4],
                                                'price_29' => $price_info[5],
                                            ]);

                                            $price->save(false);
                                        }
                                    }
                                }
                            }
                        }

                        Yii::$app->session->setFlash('flash-admin-message-success', '
                            <strong>Импорт завершен</strong><br>
                            <small>
                            Автомобили:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;добавлено: ' . $statistics['car_created'] . '<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;обновлено: ' . $statistics['car_updated'] . '<br>
                            Марки:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;добавлено: ' . $statistics['brand_created'] . '<br>
                            Модели:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;добавлено: ' . $statistics['model_created'] . '<br>
                            Классы:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;добавлено: ' . $statistics['category_created'] . '<br>
                            Города:<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;добавлено: ' . $statistics['city_created'] . '
                            </small>
                        ');
                    }
                    fclose($handle);
                } else {
                    Yii::$app->session->setFlash('flash-admin-message-error', 'Ошибка чтения файла.');
                }
            } else {
                Yii::$app->session->setFlash('flash-admin-message-error', 'Ошибка загрузки файла.');
            }

            return $this->redirect(['index']);
        } else {
            throw new BadRequestHttpException;
        }
    }

    public function actionIndex()
    {
        $query = Car::find()
            ->joinWith('translations')
            ->groupBy(Car::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Car::tableName() . '.created_at' => SORT_ASC])
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        /**
         * @var Car $model
         * @var CarTranslation|array $translation_models
         * @var CarTranslation $translation_model
         */

        $model = Car::find()
            ->where([Car::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof Car) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/car/index']);
            }

            $model = new Car;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new CarTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $prices = [
            'insurance_50' => $model->insurance50,
            'insurance_100' => $model->insurance100,
            'assistance' => $model->assistance,
        ];

        $city_prices = $model->cities;

        $model->language = Yii::$app->request->get('language', $model->language);

        if (
            $model->load(Yii::$app->request->post()) &&
            Model::loadMultiple($translation_models, Yii::$app->request->post()) &&
            Model::loadMultiple($prices, Yii::$app->request->post()) &&
            Model::loadMultiple($city_prices, Yii::$app->request->post())
        ) {
            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!Inflector::slug($translation_model->slug)) {
                    $translation_model->slug = Inflector::slug($translation_model->title);
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = CarTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model_valid = $model->validate();

            $prices_valid = true;

            foreach ($prices as $price) {
                if (!$price->validate()) {
                    $prices_valid = false;
                }
            }

            foreach ($city_prices as $price) {
                if (!$price->validate()) {
                    $prices_valid = false;
                }
            }

            $is_new_record = $model->isNewRecord;

            if (
                $translation_models[$model->language]->validate() &&
                $model_valid &&
                $prices_valid
            ) {
                $model->save(false);

                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->car_id = $model->id;

                    $translation_model->equipment = implode(', ', array_filter(array_map('trim', explode(',', $translation_model->equipment))));

                    $translation_model->save(false);
                }

                CarImage::deleteAll(['car_id' => $model->id]);
                if ($car_images = Yii::$app->request->post('CarImage', [])) {
                    $order_by = new Expression('FIELD (id, ' . implode(', ', $car_images) . ')');
                    $newImages = Attachment::find()->where(['id' => $car_images])->orderBy($order_by)->all();
                    foreach ($newImages as $newImage) {
                        $car_image_model = new CarImage;
                        $car_image_model->setAttributes([
                            'car_id' => $model->id,
                            'attachment_id' => $newImage->id,
                        ]);

                        $car_image_model->save();
                    }
                }

//                $model->unlinkAll('attributeValues', true);
//                $newAttributeValues = AttributeValue::findAll($model->attributeValues);
//                foreach ($newAttributeValues as $attributeValue) {
//                    $model->link('attributeValues', $attributeValue);
//                }

                foreach ($prices as $price) {
                    $price->car_id = $model->id;
                    $price->save(false);
                }

                foreach ($city_prices as $price) {
                    $price->car_id = $model->id;
                    $price->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Автомобиль добавлен.' : 'Автомобиль обновлен.');

                return $this->redirect(Url::to(['/admin/park/car/edit', 'id' => $model->id, 'language' => $model->language]));
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'translation_models' => $translation_models,
            'prices' => $prices,
            'city_prices' => $city_prices,
        ]);
    }

    public function actionDelete($id)
    {
        /**
         * @var Car $model
         * @var CarTranslation $translation
         */

        $model = Car::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            CarImage::deleteAll(['car_id' => $model->id]);

            //$model->unlinkAll('attributeValues', true);

            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $prices = [
                'insurance_50' => $model->insurance50,
                'insurance_100' => $model->insurance100,
                'assistance' => $model->assistance,
            ];

            foreach ($prices as $price) {
                $price->delete();
            }

            foreach ($model->cities as $city) {
                $city->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Автомобиль удален.');
        }

        return $this->redirect(Url::to(['/admin/park/car/index']));
    }
}
