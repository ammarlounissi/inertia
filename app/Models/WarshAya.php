<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id المُعرف الفريد (Primary Key) لكل آية.
 * @property int $jozz رقم الجزء (الجزء القرآني)
 * @property string $page رقم الصفحة في المصحف
 * @property int $sura_no رقم السورة
 * @property string $sura_name_en اسم السورة بالإنجليزية
 * @property string $sura_name_ar اسم السورة بالعربية
 * @property int $line_start رقم السطر الذي تبدأ منه الآية
 * @property int $line_end رقم السطر الذي تنتهي عنده الآية
 * @property int $aya_no رقم الآية داخل السورة
 * @property string $aya_text نص الآية بالخط العثماني (رواية ورش)
 */
class WarshAya extends Model
{
    // تحديد اسم الجدول (إذا كان لا يتبع اصطلاح التسمية التلقائي لـ Laravel)
    protected $table = 'warsh_ayahs';

    // بما أن الجدول للقراءة فقط، فلا توجد حقول محمية.
    protected $guarded = [];

    // إلغاء طوابع الزمن created_at و updated_at
    public $timestamps = false;

    // بما أن المفتاح الأساسي هو 'id' وهو مُعرّف تلقائي (Auto-Incrementing Integer),
    // لا نحتاج لتعريف $primaryKey أو $incrementing بشكل صريح.

    // يمكن إضافة علاقات أو مُعدلات (Accessors/Mutators) هنا لاحقاً إذا لزم الأمر
}