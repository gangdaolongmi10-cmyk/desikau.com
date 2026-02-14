<?php

namespace App\Enums;

/**
 * 都道府県
 */
enum Prefecture: string
{
    /** 北海道 */
    case HOKKAIDO = '01';

    /** 青森県 */
    case AOMORI = '02';

    /** 岩手県 */
    case IWATE = '03';

    /** 宮城県 */
    case MIYAGI = '04';

    /** 秋田県 */
    case AKITA = '05';

    /** 山形県 */
    case YAMAGATA = '06';

    /** 福島県 */
    case FUKUSHIMA = '07';

    /** 茨城県 */
    case IBARAKI = '08';

    /** 栃木県 */
    case TOCHIGI = '09';

    /** 群馬県 */
    case GUNMA = '10';

    /** 埼玉県 */
    case SAITAMA = '11';

    /** 千葉県 */
    case CHIBA = '12';

    /** 東京都 */
    case TOKYO = '13';

    /** 神奈川県 */
    case KANAGAWA = '14';

    /** 新潟県 */
    case NIIGATA = '15';

    /** 富山県 */
    case TOYAMA = '16';

    /** 石川県 */
    case ISHIKAWA = '17';

    /** 福井県 */
    case FUKUI = '18';

    /** 山梨県 */
    case YAMANASHI = '19';

    /** 長野県 */
    case NAGANO = '20';

    /** 岐阜県 */
    case GIFU = '21';

    /** 静岡県 */
    case SHIZUOKA = '22';

    /** 愛知県 */
    case AICHI = '23';

    /** 三重県 */
    case MIE = '24';

    /** 滋賀県 */
    case SHIGA = '25';

    /** 京都府 */
    case KYOTO = '26';

    /** 大阪府 */
    case OSAKA = '27';

    /** 兵庫県 */
    case HYOGO = '28';

    /** 奈良県 */
    case NARA = '29';

    /** 和歌山県 */
    case WAKAYAMA = '30';

    /** 鳥取県 */
    case TOTTORI = '31';

    /** 島根県 */
    case SHIMANE = '32';

    /** 岡山県 */
    case OKAYAMA = '33';

    /** 広島県 */
    case HIROSHIMA = '34';

    /** 山口県 */
    case YAMAGUCHI = '35';

    /** 徳島県 */
    case TOKUSHIMA = '36';

    /** 香川県 */
    case KAGAWA = '37';

    /** 愛媛県 */
    case EHIME = '38';

    /** 高知県 */
    case KOCHI = '39';

    /** 福岡県 */
    case FUKUOKA = '40';

    /** 佐賀県 */
    case SAGA = '41';

    /** 長崎県 */
    case NAGASAKI = '42';

    /** 熊本県 */
    case KUMAMOTO = '43';

    /** 大分県 */
    case OITA = '44';

    /** 宮崎県 */
    case MIYAZAKI = '45';

    /** 鹿児島県 */
    case KAGOSHIMA = '46';

    /** 沖縄県 */
    case OKINAWA = '47';

    /**
     * 都道府県名を取得
     */
    public function label(): string
    {
        return match ($this) {
            self::HOKKAIDO => '北海道',
            self::AOMORI => '青森県',
            self::IWATE => '岩手県',
            self::MIYAGI => '宮城県',
            self::AKITA => '秋田県',
            self::YAMAGATA => '山形県',
            self::FUKUSHIMA => '福島県',
            self::IBARAKI => '茨城県',
            self::TOCHIGI => '栃木県',
            self::GUNMA => '群馬県',
            self::SAITAMA => '埼玉県',
            self::CHIBA => '千葉県',
            self::TOKYO => '東京都',
            self::KANAGAWA => '神奈川県',
            self::NIIGATA => '新潟県',
            self::TOYAMA => '富山県',
            self::ISHIKAWA => '石川県',
            self::FUKUI => '福井県',
            self::YAMANASHI => '山梨県',
            self::NAGANO => '長野県',
            self::GIFU => '岐阜県',
            self::SHIZUOKA => '静岡県',
            self::AICHI => '愛知県',
            self::MIE => '三重県',
            self::SHIGA => '滋賀県',
            self::KYOTO => '京都府',
            self::OSAKA => '大阪府',
            self::HYOGO => '兵庫県',
            self::NARA => '奈良県',
            self::WAKAYAMA => '和歌山県',
            self::TOTTORI => '鳥取県',
            self::SHIMANE => '島根県',
            self::OKAYAMA => '岡山県',
            self::HIROSHIMA => '広島県',
            self::YAMAGUCHI => '山口県',
            self::TOKUSHIMA => '徳島県',
            self::KAGAWA => '香川県',
            self::EHIME => '愛媛県',
            self::KOCHI => '高知県',
            self::FUKUOKA => '福岡県',
            self::SAGA => '佐賀県',
            self::NAGASAKI => '長崎県',
            self::KUMAMOTO => '熊本県',
            self::OITA => '大分県',
            self::MIYAZAKI => '宮崎県',
            self::KAGOSHIMA => '鹿児島県',
            self::OKINAWA => '沖縄県',
        };
    }

    /**
     * すべての値を配列で取得
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * 都道府県名とコードの連想配列を取得
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
