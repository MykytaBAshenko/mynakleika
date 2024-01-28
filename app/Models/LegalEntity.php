<?php

namespace App\Models;

use App\Models\Traits\Attribute\LegalEntityAttribute;
use App\Models\Traits\Relationship\LegalEntityRelationship;
use App\Models\Traits\Scope\LegalEntityScope;
use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LegalEntity
 * @package App\Models
 * @property int      $id
 * @property int      $type
 * @property int      $customer_id
 * @property int      $doc_flow_type
 * @property boolean  $is_nds_payer
 * @property int      $verification_status
 * @property string   $nds_payer_num
 * @property string   $ipn
 * @property string   $name
 * @property string   $alias
 * @property string   $edrpou
 * @property string   $director_fio
 * @property string   $legal_address
 * @property string   $actual_address
 * @property string   $tel
 * @property string   $accountant_email
 *
 * @property Customer $customer
 */
class LegalEntity extends Model
{
    use LegalEntityRelationship;
    use LegalEntityAttribute;
    use LegalEntityScope;
    use SoftDeletes;
    use TableName;

    public const E_DOC_FLOW = 1;
    public const PAPER_DOC_FLOW = 2;

    public const VERIFICATION_STATUS_WAITING = 0;
    public const VERIFICATION_STATUS_APPROVED = 1;
    public const VERIFICATION_STATUS_REJECTED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'type',
        'verification_status',
        'is_nds_payer',
        'doc_flow_type',
        'nds_payer_num',
        'ipn',
        'name',
        'alias',
        'edrpou',
        'director_fio',
        'tel',
        'legal_address',
        'actual_address',
        'accountant_email',
    ];
}
