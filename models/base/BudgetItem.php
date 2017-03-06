<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "budgetItem".
 *
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property integer $parent_id
 * @property string $status
 * @property string $recordStatus
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property \app\models\BudgetItem $parent
 * @property \app\models\BudgetItem[] $budgetItems
 * @property \app\models\CashflowDetail[] $cashflowDetails
 * @property \app\models\MonthlyBudgetItem[] $monthlyBudgetItems
 * @property string $aliasModel
 */
abstract class BudgetItem extends \yii\db\ActiveRecord
{
    
    /**
     * ENUM field values
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';
    const RECORDSTATUS_ACTIVE = 'active';
    const RECORDSTATUS_DELETED = 'deleted';

    var $enum_labels = false;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'budgetItem';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['parent_id', 'deleted_at', 'deleted_by'], 'integer'],
            [['status', 'recordStatus'], 'string'],
            [['code'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\BudgetItem::className(), 'targetAttribute' => ['parent_id' => 'id']],
            ['status', 'in', 'range' => [
                    self::STATUS_ACTIVE,
                    self::STATUS_SUSPENDED,
                ]
            ],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'description' => 'Description',
            'parent_id' => 'Parent',
            'status' => 'Status',
            'recordStatus' => 'Record Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\BudgetItem::className(), ['id' => 'parent_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBudgetItems()
    {
        return $this->hasMany(\app\models\BudgetItem::className(), ['parent_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashflowDetails()
    {
        return $this->hasMany(\app\models\CashflowDetail::className(), ['budgetItem_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonthlyBudgetItems()
    {
        return $this->hasMany(\app\models\MonthlyBudgetItem::className(), ['budgetItem_id' => 'id']);
    }
                
    /**
     * get column status enum value label
     * @param string $value
     * @return string
     */
    public static function getStatusValueLabel($value)
    {
        $labels = self::optsStatus();

        if(isset($labels[$value])) {
            return $labels[$value];
        }

        return $value;
    }

    /**
     * column status ENUM value labels
     * @return array
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_ACTIVE => self::STATUS_ACTIVE,
            self::STATUS_SUSPENDED => self::STATUS_SUSPENDED,
        ];
    }
    
    /**
     * get column recordStatus enum value label
     * @param string $value
     * @return string
     */
    public static function getRecordStatusValueLabel($value)
    {
        $labels = self::optsRecordStatus();

        if(isset($labels[$value])) {
            return $labels[$value];
        }

        return $value;
    }

    /**
     * column recordStatus ENUM value labels
     * @return array
     */
    public static function optsRecordStatus()
    {
        return [
            self::RECORDSTATUS_ACTIVE => self::RECORDSTATUS_ACTIVE,
            self::RECORDSTATUS_DELETED => self::RECORDSTATUS_DELETED,
        ];
    }
    
}
