<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('a2_code', 2)->index();
            $table->string('a3_code', 3);
            $table->decimal('price', 22, 4)->default(0.08);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("
        INSERT INTO `" . env('DB_PREFIX') . "countries` (`name`, `slug`, `a2_code`, `a3_code`) VALUES
('Afghanistan', 'afghanistan', 'AF', 'AFG'),
('Albania', 'albania', 'AL', 'ALB'),
('Algeria', 'algeria', 'DZ', 'DZA'),
('American Samoa', 'american-samoa', 'AS', 'ASM'),
('Andorra', 'andorra', 'AD', 'AND'),
('Angola', 'angola', 'AO', 'AGO'),
('Anguilla', 'anguilla', 'AI', 'AIA'),
('Antarctica', 'antarctica', 'AQ', 'ATA'),
('Antigua And Barbuda', 'antigua-and-barbuda', 'AG', 'ATG'),
('Argentina', 'argentina', 'AR', 'ARG'),
('Armenia', 'armenia', 'AM', 'ARM'),
('Aruba', 'aruba', 'AW', 'ABW'),
('Australia', 'australia', 'AU', 'AUS'),
('Austria', 'austria', 'AT', 'AUT'),
('Azerbaijan', 'azerbaijan', 'AZ', 'AZE'),
('Bahamas', 'bahamas', 'BS', 'BHS'),
('Bahrain', 'bahrain', 'BH', 'BHR'),
('Bangladesh', 'bangladesh', 'BD', 'BGD'),
('Barbados', 'barbados', 'BB', 'BRB'),
('Belarus', 'belarus', 'BY', 'BLR'),
('Belgium', 'belgium', 'BE', 'BEL'),
('Belize', 'belize', 'BZ', 'BLZ'),
('Benin', 'benin', 'BJ', 'BEN'),
('Bermuda', 'bermuda', 'BM', 'BMU'),
('Bhutan', 'bhutan', 'BT', 'BTN'),
('Bolivia', 'bolivia', 'BO', 'BOL'),
('Bosnia And Herzegowina', 'bosnia-and-herzegowina', 'BA', 'BIH'),
('Botswana', 'botswana', 'BW', 'BWA'),
('Bouvet Island (Norway)', 'bouvet-island-norway', 'BV', 'BVT'),
('Brazil', 'brazil', 'BR', 'BRA'),
('British Indian Ocean Territory', 'british-indian-ocean-territory', 'IO', 'IOT'),
('Brunei Darussalam', 'brunei-darussalam', 'BN', 'BRN'),
('Bulgaria', 'bulgaria', 'BG', 'BGR'),
('Burkina Faso', 'burkina-faso', 'BF', 'BFA'),
('Burundi', 'burundi', 'BI', 'BDI'),
('Cambodia', 'cambodia', 'KH', 'KHM'),
('Cameroon', 'cameroon', 'CM', 'CMR'),
('Canada', 'canada', 'CA', 'CAN'),
('Cape Verde', 'cape-verde', 'CV', 'CPV'),
('Cayman Islands', 'cayman-islands', 'KY', 'CYM'),
('Central African Republic', 'central-african-republic', 'CF', 'CAF'),
('Chad', 'chad', 'TD', 'TCD'),
('Chile', 'chile', 'CL', 'CHL'),
('China', 'china', 'CN', 'CHN'),
('Christmas Island', 'christmas-island', 'CX', 'CXR'),
('Cocos (Keeling) Islands (Austrailia)', 'cocos-keeling-islands-austrailia', 'CC', 'CCK'),
('Colombia', 'colombia', 'CO', 'COL'),
('Comoros', 'comoros', 'KM', 'COM'),
('Congo', 'congo', 'CG', 'COG'),
('Congo, The Drc', 'congo-the-drc', 'CD', 'COD'),
('Cook Islands', 'cook-islands', 'CK', 'COK'),
('Costa Rica', 'costa-rica', 'CR', 'CRI'),
('Cote D\'Ivoire', 'cote-divoire', 'CI', 'CIV'),
('Croatia (Local Name: Hrvatska)', 'croatia-local-name-hrvatska', 'HR', 'HRV'),
('Cuba', 'cuba', 'CU', 'CUB'),
('Cyprus', 'cyprus', 'CY', 'CYP'),
('Czech Republic', 'czech-republic', 'CZ', 'CZE'),
('Denmark', 'denmark', 'DK', 'DNK'),
('Djibouti', 'djibouti', 'DJ', 'DJI'),
('Dominica', 'dominica', 'DM', 'DMA'),
('Dominican Republic', 'dominican-republic', 'DO', 'DOM'),
('East Timor', 'east-timor', 'TP', 'TMP'),
('Ecuador', 'ecuador', 'EC', 'ECU'),
('Egypt', 'egypt', 'EG', 'EGY'),
('El Salvador', 'el-salvador', 'SV', 'SLV'),
('Equatorial Guinea', 'equatorial-guinea', 'GQ', 'GNQ'),
('Eritrea', 'eritrea', 'ER', 'ERI'),
('Estonia', 'estonia', 'EE', 'EST'),
('Ethiopia', 'ethiopia', 'ET', 'ETH'),
('Falkland Islands (Malvinas)', 'falkland-islands-malvinas', 'FK', 'FLK'),
('Faroe Islands', 'faroe-islands', 'FO', 'FRO'),
('Fiji', 'fiji', 'FJ', 'FJI'),
('Finland', 'finland', 'FI', 'FIN'),
('France', 'france', 'FR', 'FRA'),
('France, Metropolitan', 'france-metropolitan', 'FX', 'FXX'),
('French Guiana', 'french-guiana', 'GF', 'GUF'),
('French Polynesia', 'french-polynesia', 'PF', 'PYF'),
('French Southern Territories', 'french-southern-territories', 'TF', 'ATF'),
('Gabon', 'gabon', 'GA', 'GAB'),
('Gambia', 'gambia', 'GM', 'GMB'),
('Georgia', 'georgia', 'GE', 'GEO'),
('Germany', 'germany', 'DE', 'DEU'),
('Ghana', 'ghana', 'GH', 'GHA'),
('Gibraltar', 'gibraltar', 'GI', 'GIB'),
('Greece', 'greece', 'GR', 'GRC'),
('Greenland', 'greenland', 'GL', 'GRL'),
('Grenada', 'grenada', 'GD', 'GRD'),
('Guadeloupe', 'guadeloupe', 'GP', 'GLP'),
('Guam', 'guam', 'GU', 'GUM'),
('Guatemala', 'guatemala', 'GT', 'GTM'),
('Guinea', 'guinea', 'GN', 'GIN'),
('Guinea-Bissau', 'guinea-bissau', 'GW', 'GNB'),
('Guyana', 'guyana', 'GY', 'GUY'),
('Haiti', 'haiti', 'HT', 'HTI'),
('Heard And Mc Donald Islands', 'heard-and-mc-donald-islands', 'HM', 'HMD'),
('Holy See (Vatican City State)', 'holy-see-vatican-city-state', 'VA', 'VAT'),
('Honduras', 'honduras', 'HN', 'HND'),
('Hong Kong', 'hong-kong', 'HK', 'HKG'),
('Hungary', 'hungary', 'HU', 'HUN'),
('Iceland', 'iceland', 'IS', 'ISL'),
('India', 'india', 'IN', 'IND'),
('Indonesia', 'indonesia', 'ID', 'IDN'),
('Iran (Islamic Republic Of)', 'iran-islamic-republic-of', 'IR', 'IRN'),
('Iraq', 'iraq', 'IQ', 'IRQ'),
('Ireland', 'ireland', 'IE', 'IRL'),
('Israel', 'israel', 'IL', 'ISR'),
('Italy', 'italy', 'IT', 'ITA'),
('Jamaica', 'jamaica', 'JM', 'JAM'),
('Japan', 'japan', 'JP', 'JPN'),
('Jordan', 'jordan', 'JO', 'JOR'),
('Kazakhstan', 'kazakhstan', 'KZ', 'KAZ'),
('Kenya', 'kenya', 'KE', 'KEN'),
('Kiribati', 'kiribati', 'KI', 'KIR'),
('Korea, D.P.R.O.', 'korea-dpro', 'KP', 'PRK'),
('Korea, Republic Of', 'korea-republic-of', 'KR', 'KOR'),
('Kuwait', 'kuwait', 'KW', 'KWT'),
('Kyrgyzstan', 'kyrgyzstan', 'KG', 'KGZ'),
('Laos', 'laos', 'LA', 'LAO'),
('Latvia', 'latvia', 'LV', 'LVA'),
('Lebanon', 'lebanon', 'LB', 'LBN'),
('Lesotho', 'lesotho', 'LS', 'LSO'),
('Liberia', 'liberia', 'LR', 'LBR'),
('Libyan Arab Jamahiriya', 'libyan-arab-jamahiriya', 'LY', 'LBY'),
('Liechtenstein', 'liechtenstein', 'LI', 'LIE'),
('Lithuania', 'lithuania', 'LT', 'LTU'),
('Luxembourg', 'luxembourg', 'LU', 'LUX'),
('Macau', 'macau', 'MO', 'MAC'),
('Macedonia', 'macedonia', 'MK', 'MKD'),
('Madagascar', 'madagascar', 'MG', 'MDG'),
('Malawi', 'malawi', 'MW', 'MWI'),
('Malaysia', 'malaysia', 'MY', 'MYS'),
('Maldives', 'maldives', 'MV', 'MDV'),
('Mali', 'mali', 'ML', 'MLI'),
('Malta', 'malta', 'MT', 'MLT'),
('Marshall Islands', 'marshall-islands', 'MH', 'MHL'),
('Martinique', 'martinique', 'MQ', 'MTQ'),
('Mauritania', 'mauritania', 'MR', 'MRT'),
('Mauritius', 'mauritius', 'MU', 'MUS'),
('Mayotte', 'mayotte', 'YT', 'MYT'),
('Mexico', 'mexico', 'MX', 'MEX'),
('Micronesia, Federated States Of', 'micronesia-federated-states-of', 'FM', 'FSM'),
('Moldova, Republic Of', 'moldova-republic-of', 'MD', 'MDA'),
('Monaco', 'monaco', 'MC', 'MCO'),
('Mongolia', 'mongolia', 'MN', 'MNG'),
('Montenegro', 'montenegro', 'ME', 'MNE'),
('Montserrat', 'montserrat', 'MS', 'MSR'),
('Morocco', 'morocco', 'MA', 'MAR'),
('Mozambique', 'mozambique', 'MZ', 'MOZ'),
('Myanmar (Burma)', 'myanmar-burma', 'MM', 'MMR'),
('Namibia', 'namibia', 'NA', 'NAM'),
('Nauru', 'nauru', 'NR', 'NRU'),
('Nepal', 'nepal', 'NP', 'NPL'),
('Netherlands', 'netherlands', 'NL', 'NLD'),
('Netherlands Antilles', 'netherlands-antilles', 'AN', 'ANT'),
('New Caledonia', 'new-caledonia', 'NC', 'NCL'),
('New Zealand', 'new-zealand', 'NZ', 'NZL'),
('Nicaragua', 'nicaragua', 'NI', 'NIC'),
('Niger', 'niger', 'NE', 'NER'),
('Nigeria', 'nigeria', 'NG', 'NGA'),
('Niue', 'niue', 'NU', 'NIU'),
('Norfolk Island', 'norfolk-island', 'NF', 'NFK'),
('Northern Mariana Islands', 'northern-mariana-islands', 'MP', 'MNP'),
('Norway', 'norway', 'NO', 'NOR'),
('Oman', 'oman', 'OM', 'OMN'),
('Pakistan', 'pakistan', 'PK', 'PAK'),
('Palau', 'palau', 'PW', 'PLW'),
('Panama', 'panama', 'PA', 'PAN'),
('Papua New Guinea', 'papua-new-guinea', 'PG', 'PNG'),
('Paraguay', 'paraguay', 'PY', 'PRY'),
('Peru', 'peru', 'PE', 'PER'),
('Philippines', 'philippines', 'PH', 'PHL'),
('Pitcairn', 'pitcairn', 'PN', 'PCN'),
('Poland', 'poland', 'PL', 'POL'),
('Portugal', 'portugal', 'PT', 'PRT'),
('Puerto Rico', 'puerto-rico', 'PR', 'PRI'),
('Qatar', 'qatar', 'QA', 'QAT'),
('Reunion', 'reunion', 'RE', 'REU'),
('Romania', 'romania', 'RO', 'ROU'),
('Russian Federation', 'russian-federation', 'RU', 'RUS'),
('Rwanda', 'rwanda', 'RW', 'RWA'),
('Saint Kitts And Nevis', 'saint-kitts-and-nevis', 'KN', 'KNA'),
('Saint Lucia', 'saint-lucia', 'LC', 'LCA'),
('Saint Vincent And The Grenadines', 'saint-vincent-and-the-grenadines', 'VC', 'VCT'),
('Samoa', 'samoa', 'WS', 'WSM'),
('San Marino', 'san-marino', 'SM', 'SMR'),
('Sao Tome And Principe', 'sao-tome-and-principe', 'ST', 'STP'),
('Saudi Arabia', 'saudi-arabia', 'SA', 'SAU'),
('Senegal', 'senegal', 'SN', 'SEN'),
('Serbia', 'serbia', 'RS', 'SRB'),
('Seychelles', 'seychelles', 'SC', 'SYC'),
('Sierra Leone', 'sierra-leone', 'SL', 'SLE'),
('Singapore', 'singapore', 'SG', 'SGP'),
('Slovakia (Slovak Republic)', 'slovakia-slovak-republic', 'SK', 'SVK'),
('Slovenia', 'slovenia', 'SI', 'SVN'),
('Solomon Islands', 'solomon-islands', 'SB', 'SLB'),
('Somalia', 'somalia', 'SO', 'SOM'),
('South Africa', 'south-africa', 'ZA', 'ZAF'),
('South Sudan', 'south-sudan', 'SS', 'SSD'),
('South Georgia And South S.S.', 'south-georgia-and-south-ss', 'GS', 'SGS'),
('Spain', 'spain', 'ES', 'ESP'),
('Sri Lanka', 'sri-lanka', 'LK', 'LKA'),
('St. Helena', 'st-helena', 'SH', 'SHN'),
('St. Pierre And Miquelon', 'st-pierre-and-miquelon', 'PM', 'SPM'),
('Sudan', 'sudan', 'SD', 'SDN'),
('Suriname', 'suriname', 'SR', 'SUR'),
('Svalbard And Jan Mayen Islands', 'svalbard-and-jan-mayen-islands', 'SJ', 'SJM'),
('Swaziland', 'swaziland', 'SZ', 'SWZ'),
('Sweden', 'sweden', 'SE', 'SWE'),
('Switzerland', 'switzerland', 'CH', 'CHE'),
('SYRIA', 'syria', 'SY', 'SYR'),
('Taiwan', 'taiwan', 'TW', 'TWN'),
('Tajikistan', 'tajikistan', 'TJ', 'TJK'),
('Tanzania, United Republic Of', 'tanzania-united-republic-of', 'TZ', 'TZA'),
('Thailand', 'thailand', 'TH', 'THA'),
('Togo', 'togo', 'TG', 'TGO'),
('Tokelau', 'tokelau', 'TK', 'TKL'),
('Tonga', 'tonga', 'TO', 'TON'),
('Trinidad And Tobago', 'trinidad-and-tobago', 'TT', 'TTO'),
('Tunisia', 'tunisia', 'TN', 'TUN'),
('Turkey', 'turkey', 'TR', 'TUR'),
('Turkmenistan', 'turkmenistan', 'TM', 'TKM'),
('Turks And Caicos Islands', 'turks-and-caicos-islands', 'TC', 'TCA'),
('Tuvalu', 'tuvalu', 'TV', 'TUV'),
('Uganda', 'uganda', 'UG', 'UGA'),
('Ukraine', 'ukraine', 'UA', 'UKR'),
('United Arab Emirates', 'united-arab-emirates', 'AE', 'ARE'),
('United Kingdom', 'united-kingdom', 'GB', 'GBR'),
('United States', 'united-states', 'US', 'USA'),
('U.S. Minor Islands', 'us-minor-islands', 'UM', 'UMI'),
('Uruguay', 'uruguay', 'UY', 'URY'),
('Uzbekistan', 'uzbekistan', 'UZ', 'UZB'),
('Vanuatu', 'vanuatu', 'VU', 'VUT'),
('Venezuela', 'venezuela', 'VE', 'VEN'),
('Vietnam', 'vietnam', 'VN', 'VNM'),
('Virgin Islands (British)', 'virgin-islands-british', 'VG', 'VGB'),
('Virgin Islands (U.S.)', 'virgin-islands-us', 'VI', 'VIR'),
('Wallis And Futuna Islands', 'wallis-and-futuna-islands', 'WF', 'WLF'),
('Western Sahara', 'western-sahara', 'EH', 'ESH'),
('Yemen', 'yemen', 'YE', 'YEM'),
('Zambia', 'zambia', 'ZM', 'ZMB'),
('Zimbabwe', 'zimbabwe', 'ZW', 'ZWE');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
