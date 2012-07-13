-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 13 Juillet 2012 à 08:39
-- Version du serveur: 5.1.53
-- Version de PHP: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `lsbox`
--

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `name` varchar(255) NOT NULL,
  `iso` varchar(2) NOT NULL,
  `iso3` varchar(3) NOT NULL,
  `iso_numeric` smallint(3) NOT NULL,
  `fips` varchar(2) NOT NULL,
  `capital` varchar(50) NOT NULL,
  `area` bigint(20) NOT NULL,
  `population` bigint(20) NOT NULL,
  `continent` varchar(2) NOT NULL,
  `tld` varchar(10) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_name` varchar(25) NOT NULL,
  `phone_code` varchar(10) NOT NULL,
  `postal_code_format` varchar(100) NOT NULL,
  `postal_code_regex` varchar(100) NOT NULL,
  `languages` varchar(100) NOT NULL,
  `geoname_id` int(11) NOT NULL,
  `neighbours` varchar(200) NOT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `countries`
--

INSERT INTO `countries` (`name`, `iso`, `iso3`, `iso_numeric`, `fips`, `capital`, `area`, `population`, `continent`, `tld`, `currency_code`, `currency_name`, `phone_code`, `postal_code_format`, `postal_code_regex`, `languages`, `geoname_id`, `neighbours`) VALUES
('Andorra', 'AD', 'AND', 20, 'AN', 'Andorra la Vella', 468, 84000, 'EU', '.ad', 'EUR', 'Euro', '376', 'AD###', '^(?:AD)*(\\d{3})$', 'ca', 3041565, 'ES,FR'),
('United Arab Emirates', 'AE', 'ARE', 784, 'AE', 'Abu Dhabi', 82880, 4975593, 'AS', '.ae', 'AED', 'Dirham', '971', '', '', 'ar-AE,fa,en,hi,ur', 290557, 'SA,OM'),
('Afghanistan', 'AF', 'AFG', 4, 'AF', 'Kabul', 647500, 29121286, 'AS', '.af', 'AFN', 'Afghani', '93', '', '', 'fa-AF,ps,uz-AF,tk', 1149361, 'TM,CN,IR,TJ,PK,UZ'),
('Antigua and Barbuda', 'AG', 'ATG', 28, 'AC', 'St. John''s', 443, 86754, 'NA', '.ag', 'XCD', 'Dollar', '+1-268', '', '', 'en-AG', 3576396, ''),
('Anguilla', 'AI', 'AIA', 660, 'AV', 'The Valley', 102, 13254, 'NA', '.ai', 'XCD', 'Dollar', '+1-264', '', '', 'en-AI', 3573511, ''),
('Albania', 'AL', 'ALB', 8, 'AL', 'Tirana', 28748, 2986952, 'EU', '.al', 'ALL', 'Lek', '355', '', '', 'sq,el', 783754, 'MK,GR,CS,ME,RS,XK'),
('Armenia', 'AM', 'ARM', 51, 'AM', 'Yerevan', 29800, 2968000, 'AS', '.am', 'AMD', 'Dram', '374', '######', '^(\\d{6})$', 'hy', 174982, 'GE,IR,AZ,TR'),
('Angola', 'AO', 'AGO', 24, 'AO', 'Luanda', 1246700, 13068161, 'AF', '.ao', 'AOA', 'Kwanza', '244', '', '', 'pt-AO', 3351879, 'CD,NA,ZM,CG'),
('Antarctica', 'AQ', 'ATA', 10, 'AY', '', 14000000, 0, 'AN', '.aq', '', '', '', '', '', '', 6697173, ''),
('Argentina', 'AR', 'ARG', 32, 'AR', 'Buenos Aires', 2766890, 41343201, 'SA', '.ar', 'ARS', 'Peso', '54', '@####@@@', '^([A-Z]\\d{4}[A-Z]{3})$', 'es-AR,en,it,de,fr,gn', 3865483, 'CL,BO,UY,PY,BR'),
('American Samoa', 'AS', 'ASM', 16, 'AQ', 'Pago Pago', 199, 57881, 'OC', '.as', 'USD', 'Dollar', '+1-684', '', '', 'en-AS,sm,to', 5880801, ''),
('Austria', 'AT', 'AUT', 40, 'AU', 'Vienna', 83858, 8205000, 'EU', '.at', 'EUR', 'Euro', '43', '####', '^(\\d{4})$', 'de-AT,hr,hu,sl', 2782113, 'CH,DE,HU,SK,CZ,IT,SI,LI'),
('Australia', 'AU', 'AUS', 36, 'AS', 'Canberra', 7686850, 21515754, 'OC', '.au', 'AUD', 'Dollar', '61', '####', '^(\\d{4})$', 'en-AU', 2077456, ''),
('Aruba', 'AW', 'ABW', 533, 'AA', 'Oranjestad', 193, 71566, 'NA', '.aw', 'AWG', 'Guilder', '297', '', '', 'nl-AW,es,en', 3577279, ''),
('Aland Islands', 'AX', 'ALA', 248, '', 'Mariehamn', 0, 26711, 'EU', '.ax', 'EUR', 'Euro', '+358-18', '', '', 'sv-AX', 661882, ''),
('Azerbaijan', 'AZ', 'AZE', 31, 'AJ', 'Baku', 86600, 8303512, 'AS', '.az', 'AZN', 'Manat', '994', 'AZ ####', '^(?:AZ)*(\\d{4})$', 'az,ru,hy', 587116, 'GE,IR,AM,TR,RU'),
('Bosnia and Herzegovina', 'BA', 'BIH', 70, 'BK', 'Sarajevo', 51129, 4590000, 'EU', '.ba', 'BAM', 'Marka', '387', '#####', '^(\\d{5})$', 'bs,hr-BA,sr-BA', 3277605, 'CS,HR,ME,RS'),
('Barbados', 'BB', 'BRB', 52, 'BB', 'Bridgetown', 431, 285653, 'NA', '.bb', 'BBD', 'Dollar', '+1-246', 'BB#####', '^(?:BB)*(\\d{5})$', 'en-BB', 3374084, ''),
('Bangladesh', 'BD', 'BGD', 50, 'BG', 'Dhaka', 144000, 156118464, 'AS', '.bd', 'BDT', 'Taka', '880', '####', '^(\\d{4})$', 'bn-BD,en', 1210997, 'MM,IN'),
('Belgium', 'BE', 'BEL', 56, 'BE', 'Brussels', 30510, 10403000, 'EU', '.be', 'EUR', 'Euro', '32', '####', '^(\\d{4})$', 'nl-BE,fr-BE,de-BE', 2802361, 'DE,NL,LU,FR'),
('Burkina Faso', 'BF', 'BFA', 854, 'UV', 'Ouagadougou', 274200, 16241811, 'AF', '.bf', 'XOF', 'Franc', '226', '', '', 'fr-BF', 2361809, 'NE,BJ,GH,CI,TG,ML'),
('Bulgaria', 'BG', 'BGR', 100, 'BU', 'Sofia', 110910, 7148785, 'EU', '.bg', 'BGN', 'Lev', '359', '####', '^(\\d{4})$', 'bg,tr-BG', 732800, 'MK,GR,RO,CS,TR,RS'),
('Bahrain', 'BH', 'BHR', 48, 'BA', 'Manama', 665, 738004, 'AS', '.bh', 'BHD', 'Dinar', '973', '####|###', '^(\\d{3}\\d?)$', 'ar-BH,en,fa,ur', 290291, ''),
('Burundi', 'BI', 'BDI', 108, 'BY', 'Bujumbura', 27830, 9863117, 'AF', '.bi', 'BIF', 'Franc', '257', '', '', 'fr-BI,rn', 433561, 'TZ,CD,RW'),
('Benin', 'BJ', 'BEN', 204, 'BN', 'Porto-Novo', 112620, 9056010, 'AF', '.bj', 'XOF', 'Franc', '229', '', '', 'fr-BJ', 2395170, 'NE,TG,BF,NG'),
('Saint Barthelemy', 'BL', 'BLM', 652, 'TB', 'Gustavia', 21, 8450, 'NA', '.gp', 'EUR', 'Euro', '590', '### ###', '', 'fr', 3578476, ''),
('Bermuda', 'BM', 'BMU', 60, 'BD', 'Hamilton', 53, 65365, 'NA', '.bm', 'BMD', 'Dollar', '+1-441', '@@ ##', '^([A-Z]{2}\\d{2})$', 'en-BM,pt', 3573345, ''),
('Brunei', 'BN', 'BRN', 96, 'BX', 'Bandar Seri Begawan', 5770, 395027, 'AS', '.bn', 'BND', 'Dollar', '673', '@@####', '^([A-Z]{2}\\d{4})$', 'ms-BN,en-BN', 1820814, 'MY'),
('Bolivia', 'BO', 'BOL', 68, 'BL', 'Sucre', 1098580, 9947418, 'SA', '.bo', 'BOB', 'Boliviano', '591', '', '', 'es-BO,qu,ay', 3923057, 'PE,CL,PY,BR,AR'),
('Bonaire, Saint Eustatius and Saba ', 'BQ', 'BES', 535, '', '', 0, 18012, 'NA', '.bq', 'USD', 'Dollar', '599', '', '', 'nl,pap,en', 7626844, ''),
('Brazil', 'BR', 'BRA', 76, 'BR', 'Brasilia', 8511965, 201103330, 'SA', '.br', 'BRL', 'Real', '55', '#####-###', '^(\\d{8})$', 'pt-BR,es,en,fr', 3469034, 'SR,PE,BO,UY,GY,PY,GF,VE,CO,AR'),
('Bahamas', 'BS', 'BHS', 44, 'BF', 'Nassau', 13940, 301790, 'NA', '.bs', 'BSD', 'Dollar', '+1-242', '', '', 'en-BS', 3572887, ''),
('Bhutan', 'BT', 'BTN', 64, 'BT', 'Thimphu', 47000, 699847, 'AS', '.bt', 'BTN', 'Ngultrum', '975', '', '', 'dz', 1252634, 'CN,IN'),
('Bouvet Island', 'BV', 'BVT', 74, 'BV', '', 0, 0, 'AN', '.bv', 'NOK', 'Krone', '', '', '', '', 3371123, ''),
('Botswana', 'BW', 'BWA', 72, 'BC', 'Gaborone', 600370, 2029307, 'AF', '.bw', 'BWP', 'Pula', '267', '', '', 'en-BW,tn-BW', 933860, 'ZW,ZA,NA'),
('Belarus', 'BY', 'BLR', 112, 'BO', 'Minsk', 207600, 9685000, 'EU', '.by', 'BYR', 'Ruble', '375', '######', '^(\\d{6})$', 'be,ru', 630336, 'PL,LT,UA,RU,LV'),
('Belize', 'BZ', 'BLZ', 84, 'BH', 'Belmopan', 22966, 314522, 'NA', '.bz', 'BZD', 'Dollar', '501', '', '', 'en-BZ,es', 3582678, 'GT,MX'),
('Canada', 'CA', 'CAN', 124, 'CA', 'Ottawa', 9984670, 33679000, 'NA', '.ca', 'CAD', 'Dollar', '1', '@#@ #@#', '^([a-zA-Z]\\d[a-zA-Z]\\d[a-zA-Z]\\d)$', 'en-CA,fr-CA,iu', 6251999, 'US'),
('Cocos Islands', 'CC', 'CCK', 166, 'CK', 'West Island', 14, 628, 'AS', '.cc', 'AUD', 'Dollar', '61', '', '', 'ms-CC,en', 1547376, ''),
('Democratic Republic of the Congo', 'CD', 'COD', 180, 'CG', 'Kinshasa', 2345410, 70916439, 'AF', '.cd', 'CDF', 'Franc', '243', '', '', 'fr-CD,ln,kg', 203312, 'TZ,CF,SS,RW,ZM,BI,UG,CG,AO'),
('Central African Republic', 'CF', 'CAF', 140, 'CT', 'Bangui', 622984, 4844927, 'AF', '.cf', 'XAF', 'Franc', '236', '', '', 'fr-CF,sg,ln,kg', 239880, 'TD,SD,CD,SS,CM,CG'),
('Republic of the Congo', 'CG', 'COG', 178, 'CF', 'Brazzaville', 342000, 3039126, 'AF', '.cg', 'XAF', 'Franc', '242', '', '', 'fr-CG,kg,ln-CG', 2260494, 'CF,GA,CD,CM,AO'),
('Switzerland', 'CH', 'CHE', 756, 'SZ', 'Berne', 41290, 7581000, 'EU', '.ch', 'CHF', 'Franc', '41', '####', '^(\\d{4})$', 'de-CH,fr-CH,it-CH,rm', 2658434, 'DE,IT,LI,FR,AT'),
('Ivory Coast', 'CI', 'CIV', 384, 'IV', 'Yamoussoukro', 322460, 21058798, 'AF', '.ci', 'XOF', 'Franc', '225', '', '', 'fr-CI', 2287781, 'LR,GH,GN,BF,ML'),
('Cook Islands', 'CK', 'COK', 184, 'CW', 'Avarua', 240, 21388, 'OC', '.ck', 'NZD', 'Dollar', '682', '', '', 'en-CK,mi', 1899402, ''),
('Chile', 'CL', 'CHL', 152, 'CI', 'Santiago', 756950, 16746491, 'SA', '.cl', 'CLP', 'Peso', '56', '#######', '^(\\d{7})$', 'es-CL', 3895114, 'PE,BO,AR'),
('Cameroon', 'CM', 'CMR', 120, 'CM', 'Yaounde', 475440, 19294149, 'AF', '.cm', 'XAF', 'Franc', '237', '', '', 'en-CM,fr-CM', 2233387, 'TD,CF,GA,GQ,CG,NG'),
('China', 'CN', 'CHN', 156, 'CH', 'Beijing', 9596960, 1330044000, 'AS', '.cn', 'CNY', 'Yuan Renminbi', '86', '######', '^(\\d{6})$', 'zh-CN,yue,wuu,dta,ug,za', 1814991, 'LA,BT,TJ,KZ,MN,AF,NP,MM,KG,PK,KP,RU,VN,IN'),
('Colombia', 'CO', 'COL', 170, 'CO', 'Bogota', 1138910, 44205293, 'SA', '.co', 'COP', 'Peso', '57', '', '', 'es-CO', 3686110, 'EC,PE,PA,BR,VE'),
('Costa Rica', 'CR', 'CRI', 188, 'CS', 'San Jose', 51100, 4516220, 'NA', '.cr', 'CRC', 'Colon', '506', '####', '^(\\d{4})$', 'es-CR,en', 3624060, 'PA,NI'),
('Cuba', 'CU', 'CUB', 192, 'CU', 'Havana', 110860, 11423000, 'NA', '.cu', 'CUP', 'Peso', '53', 'CP #####', '^(?:CP)*(\\d{5})$', 'es-CU', 3562981, 'US'),
('Cape Verde', 'CV', 'CPV', 132, 'CV', 'Praia', 4033, 508659, 'AF', '.cv', 'CVE', 'Escudo', '238', '####', '^(\\d{4})$', 'pt-CV', 3374766, ''),
('Curacao', 'CW', 'CUW', 531, 'UC', 'Willemstad', 0, 141766, 'NA', '.cw', 'ANG', 'Guilder', '599', '', '', 'nl,pap', 7626836, ''),
('Christmas Island', 'CX', 'CXR', 162, 'KT', 'Flying Fish Cove', 135, 1500, 'AS', '.cx', 'AUD', 'Dollar', '61', '####', '^(\\d{4})$', 'en,zh,ms-CC', 2078138, ''),
('Cyprus', 'CY', 'CYP', 196, 'CY', 'Nicosia', 9250, 1102677, 'EU', '.cy', 'EUR', 'Euro', '357', '####', '^(\\d{4})$', 'el-CY,tr-CY,en', 146669, ''),
('Czech Republic', 'CZ', 'CZE', 203, 'EZ', 'Prague', 78866, 10476000, 'EU', '.cz', 'CZK', 'Koruna', '420', '### ##', '^(\\d{5})$', 'cs,sk', 3077311, 'PL,DE,SK,AT'),
('Germany', 'DE', 'DEU', 276, 'GM', 'Berlin', 357021, 81802257, 'EU', '.de', 'EUR', 'Euro', '49', '#####', '^(\\d{5})$', 'de', 2921044, 'CH,PL,NL,DK,BE,CZ,LU,FR,AT'),
('Djibouti', 'DJ', 'DJI', 262, 'DJ', 'Djibouti', 23000, 740528, 'AF', '.dj', 'DJF', 'Franc', '253', '', '', 'fr-DJ,ar,so-DJ,aa', 223816, 'ER,ET,SO'),
('Denmark', 'DK', 'DNK', 208, 'DA', 'Copenhagen', 43094, 5484000, 'EU', '.dk', 'DKK', 'Krone', '45', '####', '^(\\d{4})$', 'da-DK,en,fo,de-DK', 2623032, 'DE'),
('Dominica', 'DM', 'DMA', 212, 'DO', 'Roseau', 754, 72813, 'NA', '.dm', 'XCD', 'Dollar', '+1-767', '', '', 'en-DM', 3575830, ''),
('Dominican Republic', 'DO', 'DOM', 214, 'DR', 'Santo Domingo', 48730, 9823821, 'NA', '.do', 'DOP', 'Peso', '+1-809 and', '#####', '^(\\d{5})$', 'es-DO', 3508796, 'HT'),
('Algeria', 'DZ', 'DZA', 12, 'AG', 'Algiers', 2381740, 34586184, 'AF', '.dz', 'DZD', 'Dinar', '213', '#####', '^(\\d{5})$', 'ar-DZ', 2589581, 'NE,EH,LY,MR,TN,MA,ML'),
('Ecuador', 'EC', 'ECU', 218, 'EC', 'Quito', 283560, 14790608, 'SA', '.ec', 'USD', 'Dollar', '593', '@####@', '^([a-zA-Z]\\d{4}[a-zA-Z])$', 'es-EC', 3658394, 'PE,CO'),
('Estonia', 'EE', 'EST', 233, 'EN', 'Tallinn', 45226, 1291170, 'EU', '.ee', 'EUR', 'Euro', '372', '#####', '^(\\d{5})$', 'et,ru', 453733, 'RU,LV'),
('Egypt', 'EG', 'EGY', 818, 'EG', 'Cairo', 1001450, 80471869, 'AF', '.eg', 'EGP', 'Pound', '20', '#####', '^(\\d{5})$', 'ar-EG,en,fr', 357994, 'LY,SD,IL'),
('Western Sahara', 'EH', 'ESH', 732, 'WI', 'El-Aaiun', 266000, 273008, 'AF', '.eh', 'MAD', 'Dirham', '212', '', '', 'ar,mey', 2461445, 'DZ,MR,MA'),
('Eritrea', 'ER', 'ERI', 232, 'ER', 'Asmara', 121320, 5792984, 'AF', '.er', 'ERN', 'Nakfa', '291', '', '', 'aa-ER,ar,tig,kun,ti-ER', 338010, 'ET,SD,DJ'),
('Spain', 'ES', 'ESP', 724, 'SP', 'Madrid', 504782, 46505963, 'EU', '.es', 'EUR', 'Euro', '34', '#####', '^(\\d{5})$', 'es-ES,ca,gl,eu,oc', 2510769, 'AD,PT,GI,FR,MA'),
('Ethiopia', 'ET', 'ETH', 231, 'ET', 'Addis Ababa', 1127127, 88013491, 'AF', '.et', 'ETB', 'Birr', '251', '####', '^(\\d{4})$', 'am,en-ET,om-ET,ti-ET,so-ET,sid', 337996, 'ER,KE,SD,SS,SO,DJ'),
('Finland', 'FI', 'FIN', 246, 'FI', 'Helsinki', 337030, 5244000, 'EU', '.fi', 'EUR', 'Euro', '358', '#####', '^(?:FI)*(\\d{5})$', 'fi-FI,sv-FI,smn', 660013, 'NO,RU,SE'),
('Fiji', 'FJ', 'FJI', 242, 'FJ', 'Suva', 18270, 875983, 'OC', '.fj', 'FJD', 'Dollar', '679', '', '', 'en-FJ,fj', 2205218, ''),
('Falkland Islands', 'FK', 'FLK', 238, 'FK', 'Stanley', 12173, 2638, 'SA', '.fk', 'FKP', 'Pound', '500', '', '', 'en-FK', 3474414, ''),
('Micronesia', 'FM', 'FSM', 583, 'FM', 'Palikir', 702, 107708, 'OC', '.fm', 'USD', 'Dollar', '691', '#####', '^(\\d{5})$', 'en-FM,chk,pon,yap,kos,uli,woe,nkr,kpg', 2081918, ''),
('Faroe Islands', 'FO', 'FRO', 234, 'FO', 'Torshavn', 1399, 48228, 'EU', '.fo', 'DKK', 'Krone', '298', 'FO-###', '^(?:FO)*(\\d{3})$', 'fo,da-FO', 2622320, ''),
('France', 'FR', 'FRA', 250, 'FR', 'Paris', 547030, 64768389, 'EU', '.fr', 'EUR', 'Euro', '33', '#####', '^(\\d{5})$', 'fr-FR,frp,br,co,ca,eu,oc', 3017382, 'CH,DE,BE,LU,IT,AD,MC,ES'),
('Gabon', 'GA', 'GAB', 266, 'GB', 'Libreville', 267667, 1545255, 'AF', '.ga', 'XAF', 'Franc', '241', '', '', 'fr-GA', 2400553, 'CM,GQ,CG'),
('United Kingdom', 'GB', 'GBR', 826, 'UK', 'London', 244820, 62348447, 'EU', '.uk', 'GBP', 'Pound', '44', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|GIR0AA', '^(([A-Z]\\d{2}[A-Z]{2})|([A-Z]\\d{3}[A-Z]{2})|([A-Z]{2}\\d{2}[A-Z]{2})|([A-Z]{2}\\d{3}[A-Z]{2})|([A-Z]\\d', 'en-GB,cy-GB,gd', 2635167, 'IE'),
('Grenada', 'GD', 'GRD', 308, 'GJ', 'St. George''s', 344, 107818, 'NA', '.gd', 'XCD', 'Dollar', '+1-473', '', '', 'en-GD', 3580239, ''),
('Georgia', 'GE', 'GEO', 268, 'GG', 'Tbilisi', 69700, 4630000, 'AS', '.ge', 'GEL', 'Lari', '995', '####', '^(\\d{4})$', 'ka,ru,hy,az', 614540, 'AM,AZ,TR,RU'),
('French Guiana', 'GF', 'GUF', 254, 'FG', 'Cayenne', 91000, 195506, 'SA', '.gf', 'EUR', 'Euro', '594', '#####', '^((97)|(98)3\\d{2})$', 'fr-GF', 3381670, 'SR,BR'),
('Guernsey', 'GG', 'GGY', 831, 'GK', 'St Peter Port', 78, 65228, 'EU', '.gg', 'GBP', 'Pound', '+44-1481', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|GIR0AA', '^(([A-Z]\\d{2}[A-Z]{2})|([A-Z]\\d{3}[A-Z]{2})|([A-Z]{2}\\d{2}[A-Z]{2})|([A-Z]{2}\\d{3}[A-Z]{2})|([A-Z]\\d', 'en,fr', 3042362, ''),
('Ghana', 'GH', 'GHA', 288, 'GH', 'Accra', 239460, 24339838, 'AF', '.gh', 'GHS', 'Cedi', '233', '', '', 'en-GH,ak,ee,tw', 2300660, 'CI,TG,BF'),
('Gibraltar', 'GI', 'GIB', 292, 'GI', 'Gibraltar', 7, 27884, 'EU', '.gi', 'GIP', 'Pound', '350', '', '', 'en-GI,es,it,pt', 2411586, 'ES'),
('Greenland', 'GL', 'GRL', 304, 'GL', 'Nuuk', 2166086, 56375, 'NA', '.gl', 'DKK', 'Krone', '299', '####', '^(\\d{4})$', 'kl,da-GL,en', 3425505, ''),
('Gambia', 'GM', 'GMB', 270, 'GA', 'Banjul', 11300, 1593256, 'AF', '.gm', 'GMD', 'Dalasi', '220', '', '', 'en-GM,mnk,wof,wo,ff', 2413451, 'SN'),
('Guinea', 'GN', 'GIN', 324, 'GV', 'Conakry', 245857, 10324025, 'AF', '.gn', 'GNF', 'Franc', '224', '', '', 'fr-GN', 2420477, 'LR,SN,SL,CI,GW,ML'),
('Guadeloupe', 'GP', 'GLP', 312, 'GP', 'Basse-Terre', 1780, 443000, 'NA', '.gp', 'EUR', 'Euro', '590', '#####', '^((97)|(98)\\d{3})$', 'fr-GP', 3579143, 'AN'),
('Equatorial Guinea', 'GQ', 'GNQ', 226, 'EK', 'Malabo', 28051, 1014999, 'AF', '.gq', 'XAF', 'Franc', '240', '', '', 'es-GQ,fr', 2309096, 'GA,CM'),
('Greece', 'GR', 'GRC', 300, 'GR', 'Athens', 131940, 11000000, 'EU', '.gr', 'EUR', 'Euro', '30', '### ##', '^(\\d{5})$', 'el-GR,en,fr', 390903, 'AL,MK,TR,BG'),
('South Georgia and the South Sandwich Islands', 'GS', 'SGS', 239, 'SX', 'Grytviken', 3903, 30, 'AN', '.gs', 'GBP', 'Pound', '', '', '', 'en', 3474415, ''),
('Guatemala', 'GT', 'GTM', 320, 'GT', 'Guatemala City', 108890, 13550440, 'NA', '.gt', 'GTQ', 'Quetzal', '502', '#####', '^(\\d{5})$', 'es-GT', 3595528, 'MX,HN,BZ,SV'),
('Guam', 'GU', 'GUM', 316, 'GQ', 'Hagatna', 549, 159358, 'OC', '.gu', 'USD', 'Dollar', '+1-671', '969##', '^(969\\d{2})$', 'en-GU,ch-GU', 4043988, ''),
('Guinea-Bissau', 'GW', 'GNB', 624, 'PU', 'Bissau', 36120, 1565126, 'AF', '.gw', 'XOF', 'Franc', '245', '####', '^(\\d{4})$', 'pt-GW,pov', 2372248, 'SN,GN'),
('Guyana', 'GY', 'GUY', 328, 'GY', 'Georgetown', 214970, 748486, 'SA', '.gy', 'GYD', 'Dollar', '592', '', '', 'en-GY', 3378535, 'SR,BR,VE'),
('Hong Kong', 'HK', 'HKG', 344, 'HK', 'Hong Kong', 1092, 6898686, 'AS', '.hk', 'HKD', 'Dollar', '852', '', '', 'zh-HK,yue,zh,en', 1819730, ''),
('Heard Island and McDonald Islands', 'HM', 'HMD', 334, 'HM', '', 412, 0, 'AN', '.hm', 'AUD', 'Dollar', '', '', '', '', 1547314, ''),
('Honduras', 'HN', 'HND', 340, 'HO', 'Tegucigalpa', 112090, 7989415, 'NA', '.hn', 'HNL', 'Lempira', '504', '@@####', '^([A-Z]{2}\\d{4})$', 'es-HN', 3608932, 'GT,NI,SV'),
('Croatia', 'HR', 'HRV', 191, 'HR', 'Zagreb', 56542, 4491000, 'EU', '.hr', 'HRK', 'Kuna', '385', 'HR-#####', '^(?:HR)*(\\d{5})$', 'hr-HR,sr', 3202326, 'HU,SI,CS,BA,ME,RS'),
('Haiti', 'HT', 'HTI', 332, 'HA', 'Port-au-Prince', 27750, 9648924, 'NA', '.ht', 'HTG', 'Gourde', '509', 'HT####', '^(?:HT)*(\\d{4})$', 'ht,fr-HT', 3723988, 'DO'),
('Hungary', 'HU', 'HUN', 348, 'HU', 'Budapest', 93030, 9930000, 'EU', '.hu', 'HUF', 'Forint', '36', '####', '^(\\d{4})$', 'hu-HU', 719819, 'SK,SI,RO,UA,CS,HR,AT,RS'),
('Indonesia', 'ID', 'IDN', 360, 'ID', 'Jakarta', 1919440, 242968342, 'AS', '.id', 'IDR', 'Rupiah', '62', '#####', '^(\\d{5})$', 'id,en,nl,jv', 1643084, 'PG,TL,MY'),
('Ireland', 'IE', 'IRL', 372, 'EI', 'Dublin', 70280, 4622917, 'EU', '.ie', 'EUR', 'Euro', '353', '', '', 'en-IE,ga-IE', 2963597, 'GB'),
('Israel', 'IL', 'ISR', 376, 'IS', 'Jerusalem', 20770, 7353985, 'AS', '.il', 'ILS', 'Shekel', '972', '#####', '^(\\d{5})$', 'he,ar-IL,en-IL,', 294640, 'SY,JO,LB,EG,PS'),
('Isle of Man', 'IM', 'IMN', 833, 'IM', 'Douglas, Isle of Man', 572, 75049, 'EU', '.im', 'GBP', 'Pound', '+44-1624', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|GIR0AA', '^(([A-Z]\\d{2}[A-Z]{2})|([A-Z]\\d{3}[A-Z]{2})|([A-Z]{2}\\d{2}[A-Z]{2})|([A-Z]{2}\\d{3}[A-Z]{2})|([A-Z]\\d', 'en,gv', 3042225, ''),
('India', 'IN', 'IND', 356, 'IN', 'New Delhi', 3287590, 1173108018, 'AS', '.in', 'INR', 'Rupee', '91', '######', '^(\\d{6})$', 'en-IN,hi,bn,te,mr,ta,ur,gu,kn,ml,or,pa,as,bh,sat,ks,ne,sd,kok,doi,mni,sit,sa,fr,lus,inc', 1269750, 'CN,NP,MM,BT,PK,BD'),
('British Indian Ocean Territory', 'IO', 'IOT', 86, 'IO', 'Diego Garcia', 60, 4000, 'AS', '.io', 'USD', 'Dollar', '246', '', '', 'en-IO', 1282588, ''),
('Iraq', 'IQ', 'IRQ', 368, 'IZ', 'Baghdad', 437072, 29671605, 'AS', '.iq', 'IQD', 'Dinar', '964', '#####', '^(\\d{5})$', 'ar-IQ,ku,hy', 99237, 'SY,SA,IR,JO,TR,KW'),
('Iran', 'IR', 'IRN', 364, 'IR', 'Tehran', 1648000, 76923300, 'AS', '.ir', 'IRR', 'Rial', '98', '##########', '^(\\d{10})$', 'fa-IR,ku', 130758, 'TM,AF,IQ,AM,PK,AZ,TR'),
('Iceland', 'IS', 'ISL', 352, 'IC', 'Reykjavik', 103000, 308910, 'EU', '.is', 'ISK', 'Krona', '354', '###', '^(\\d{3})$', 'is,en,de,da,sv,no', 2629691, ''),
('Italy', 'IT', 'ITA', 380, 'IT', 'Rome', 301230, 60340328, 'EU', '.it', 'EUR', 'Euro', '39', '#####', '^(\\d{5})$', 'it-IT,de-IT,fr-IT,sc,ca,co,sl', 3175395, 'CH,VA,SI,SM,FR,AT'),
('Jersey', 'JE', 'JEY', 832, 'JE', 'Saint Helier', 116, 90812, 'EU', '.je', 'GBP', 'Pound', '+44-1534', '@# #@@|@## #@@|@@# #@@|@@## #@@|@#@ #@@|@@#@ #@@|GIR0AA', '^(([A-Z]\\d{2}[A-Z]{2})|([A-Z]\\d{3}[A-Z]{2})|([A-Z]{2}\\d{2}[A-Z]{2})|([A-Z]{2}\\d{3}[A-Z]{2})|([A-Z]\\d', 'en,pt', 3042142, ''),
('Jamaica', 'JM', 'JAM', 388, 'JM', 'Kingston', 10991, 2847232, 'NA', '.jm', 'JMD', 'Dollar', '+1-876', '', '', 'en-JM', 3489940, ''),
('Jordan', 'JO', 'JOR', 400, 'JO', 'Amman', 92300, 6407085, 'AS', '.jo', 'JOD', 'Dinar', '962', '#####', '^(\\d{5})$', 'ar-JO,en', 248816, 'SY,SA,IQ,IL,PS'),
('Japan', 'JP', 'JPN', 392, 'JA', 'Tokyo', 377835, 127288000, 'AS', '.jp', 'JPY', 'Yen', '81', '###-####', '^(\\d{7})$', 'ja', 1861060, ''),
('Kenya', 'KE', 'KEN', 404, 'KE', 'Nairobi', 582650, 40046566, 'AF', '.ke', 'KES', 'Shilling', '254', '#####', '^(\\d{5})$', 'en-KE,sw-KE', 192950, 'ET,TZ,SS,SO,UG'),
('Kyrgyzstan', 'KG', 'KGZ', 417, 'KG', 'Bishkek', 198500, 5508626, 'AS', '.kg', 'KGS', 'Som', '996', '######', '^(\\d{6})$', 'ky,uz,ru', 1527747, 'CN,TJ,UZ,KZ'),
('Cambodia', 'KH', 'KHM', 116, 'CB', 'Phnom Penh', 181040, 14453680, 'AS', '.kh', 'KHR', 'Riels', '855', '#####', '^(\\d{5})$', 'km,fr,en', 1831722, 'LA,TH,VN'),
('Kiribati', 'KI', 'KIR', 296, 'KR', 'Tarawa', 811, 92533, 'OC', '.ki', 'AUD', 'Dollar', '686', '', '', 'en-KI,gil', 4030945, ''),
('Comoros', 'KM', 'COM', 174, 'CN', 'Moroni', 2170, 773407, 'AF', '.km', 'KMF', 'Franc', '269', '', '', 'ar,fr-KM', 921929, ''),
('Saint Kitts and Nevis', 'KN', 'KNA', 659, 'SC', 'Basseterre', 261, 49898, 'NA', '.kn', 'XCD', 'Dollar', '+1-869', '', '', 'en-KN', 3575174, ''),
('North Korea', 'KP', 'PRK', 408, 'KN', 'Pyongyang', 120540, 22912177, 'AS', '.kp', 'KPW', 'Won', '850', '###-###', '^(\\d{6})$', 'ko-KP', 1873107, 'CN,KR,RU'),
('South Korea', 'KR', 'KOR', 410, 'KS', 'Seoul', 98480, 48422644, 'AS', '.kr', 'KRW', 'Won', '82', 'SEOUL ###-###', '^(?:SEOUL)*(\\d{6})$', 'ko-KR,en', 1835841, 'KP'),
('Kosovo', 'XK', 'XKX', 0, 'KV', 'Pristina', 0, 1800000, 'EU', '', 'EUR', 'Euro', '', '', '', 'sq,sr', 831053, 'RS,AL,MK,ME'),
('Kuwait', 'KW', 'KWT', 414, 'KU', 'Kuwait City', 17820, 2789132, 'AS', '.kw', 'KWD', 'Dinar', '965', '#####', '^(\\d{5})$', 'ar-KW,en', 285570, 'SA,IQ'),
('Cayman Islands', 'KY', 'CYM', 136, 'CJ', 'George Town', 262, 44270, 'NA', '.ky', 'KYD', 'Dollar', '+1-345', '', '', 'en-KY', 3580718, ''),
('Kazakhstan', 'KZ', 'KAZ', 398, 'KZ', 'Astana', 2717300, 15340000, 'AS', '.kz', 'KZT', 'Tenge', '7', '######', '^(\\d{6})$', 'kk,ru', 1522867, 'TM,CN,KG,UZ,RU'),
('Laos', 'LA', 'LAO', 418, 'LA', 'Vientiane', 236800, 6368162, 'AS', '.la', 'LAK', 'Kip', '856', '#####', '^(\\d{5})$', 'lo,fr,en', 1655842, 'CN,MM,KH,TH,VN'),
('Lebanon', 'LB', 'LBN', 422, 'LE', 'Beirut', 10400, 4125247, 'AS', '.lb', 'LBP', 'Pound', '961', '#### ####|####', '^(\\d{4}(\\d{4})?)$', 'ar-LB,fr-LB,en,hy', 272103, 'SY,IL'),
('Saint Lucia', 'LC', 'LCA', 662, 'ST', 'Castries', 616, 160922, 'NA', '.lc', 'XCD', 'Dollar', '+1-758', '', '', 'en-LC', 3576468, ''),
('Liechtenstein', 'LI', 'LIE', 438, 'LS', 'Vaduz', 160, 35000, 'EU', '.li', 'CHF', 'Franc', '423', '####', '^(\\d{4})$', 'de-LI', 3042058, 'CH,AT'),
('Sri Lanka', 'LK', 'LKA', 144, 'CE', 'Colombo', 65610, 21513990, 'AS', '.lk', 'LKR', 'Rupee', '94', '#####', '^(\\d{5})$', 'si,ta,en', 1227603, ''),
('Liberia', 'LR', 'LBR', 430, 'LI', 'Monrovia', 111370, 3685076, 'AF', '.lr', 'LRD', 'Dollar', '231', '####', '^(\\d{4})$', 'en-LR', 2275384, 'SL,CI,GN'),
('Lesotho', 'LS', 'LSO', 426, 'LT', 'Maseru', 30355, 1919552, 'AF', '.ls', 'LSL', 'Loti', '266', '###', '^(\\d{3})$', 'en-LS,st,zu,xh', 932692, 'ZA'),
('Lithuania', 'LT', 'LTU', 440, 'LH', 'Vilnius', 65200, 3565000, 'EU', '.lt', 'LTL', 'Litas', '370', 'LT-#####', '^(?:LT)*(\\d{5})$', 'lt,ru,pl', 597427, 'PL,BY,RU,LV'),
('Luxembourg', 'LU', 'LUX', 442, 'LU', 'Luxembourg', 2586, 497538, 'EU', '.lu', 'EUR', 'Euro', '352', '####', '^(\\d{4})$', 'lb,de-LU,fr-LU', 2960313, 'DE,BE,FR'),
('Latvia', 'LV', 'LVA', 428, 'LG', 'Riga', 64589, 2217969, 'EU', '.lv', 'LVL', 'Lat', '371', 'LV-####', '^(?:LV)*(\\d{4})$', 'lv,ru,lt', 458258, 'LT,EE,BY,RU'),
('Libya', 'LY', 'LBY', 434, 'LY', 'Tripolis', 1759540, 6461454, 'AF', '.ly', 'LYD', 'Dinar', '218', '', '', 'ar-LY,it,en', 2215636, 'TD,NE,DZ,SD,TN,EG'),
('Morocco', 'MA', 'MAR', 504, 'MO', 'Rabat', 446550, 31627428, 'AF', '.ma', 'MAD', 'Dirham', '212', '#####', '^(\\d{5})$', 'ar-MA,fr', 2542007, 'DZ,EH,ES'),
('Monaco', 'MC', 'MCO', 492, 'MN', 'Monaco', 2, 32965, 'EU', '.mc', 'EUR', 'Euro', '377', '#####', '^(\\d{5})$', 'fr-MC,en,it', 2993457, 'FR'),
('Moldova', 'MD', 'MDA', 498, 'MD', 'Chisinau', 33843, 4324000, 'EU', '.md', 'MDL', 'Leu', '373', 'MD-####', '^(?:MD)*(\\d{4})$', 'ro,ru,gag,tr', 617790, 'RO,UA'),
('Montenegro', 'ME', 'MNE', 499, 'MJ', 'Podgorica', 14026, 666730, 'EU', '.me', 'EUR', 'Euro', '382', '#####', '^(\\d{5})$', 'sr,hu,bs,sq,hr,rom', 3194884, 'AL,HR,BA,RS,XK'),
('Saint Martin', 'MF', 'MAF', 663, 'RN', 'Marigot', 53, 35925, 'NA', '.gp', 'EUR', 'Euro', '590', '### ###', '', 'fr', 3578421, 'SX'),
('Madagascar', 'MG', 'MDG', 450, 'MA', 'Antananarivo', 587040, 21281844, 'AF', '.mg', 'MGA', 'Ariary', '261', '###', '^(\\d{3})$', 'fr-MG,mg', 1062947, ''),
('Marshall Islands', 'MH', 'MHL', 584, 'RM', 'Majuro', 181, 65859, 'OC', '.mh', 'USD', 'Dollar', '692', '', '', 'mh,en-MH', 2080185, ''),
('Macedonia', 'MK', 'MKD', 807, 'MK', 'Skopje', 25333, 2061000, 'EU', '.mk', 'MKD', 'Denar', '389', '####', '^(\\d{4})$', 'mk,sq,tr,rmm,sr', 718075, 'AL,GR,CS,BG,RS,XK'),
('Mali', 'ML', 'MLI', 466, 'ML', 'Bamako', 1240000, 13796354, 'AF', '.ml', 'XOF', 'Franc', '223', '', '', 'fr-ML,bm', 2453866, 'SN,NE,DZ,CI,GN,MR,BF'),
('Myanmar', 'MM', 'MMR', 104, 'BM', 'Nay Pyi Taw', 678500, 53414374, 'AS', '.mm', 'MMK', 'Kyat', '95', '#####', '^(\\d{5})$', 'my', 1327865, 'CN,LA,TH,BD,IN'),
('Mongolia', 'MN', 'MNG', 496, 'MG', 'Ulan Bator', 1565000, 3086918, 'AS', '.mn', 'MNT', 'Tugrik', '976', '######', '^(\\d{6})$', 'mn,ru', 2029969, 'CN,RU'),
('Macao', 'MO', 'MAC', 446, 'MC', 'Macao', 254, 449198, 'AS', '.mo', 'MOP', 'Pataca', '853', '', '', 'zh,zh-MO,pt', 1821275, ''),
('Northern Mariana Islands', 'MP', 'MNP', 580, 'CQ', 'Saipan', 477, 53883, 'OC', '.mp', 'USD', 'Dollar', '+1-670', '', '', 'fil,tl,zh,ch-MP,en-MP', 4041468, ''),
('Martinique', 'MQ', 'MTQ', 474, 'MB', 'Fort-de-France', 1100, 432900, 'NA', '.mq', 'EUR', 'Euro', '596', '#####', '^(\\d{5})$', 'fr-MQ', 3570311, ''),
('Mauritania', 'MR', 'MRT', 478, 'MR', 'Nouakchott', 1030700, 3205060, 'AF', '.mr', 'MRO', 'Ouguiya', '222', '', '', 'ar-MR,fuc,snk,fr,mey,wo', 2378080, 'SN,DZ,EH,ML'),
('Montserrat', 'MS', 'MSR', 500, 'MH', 'Plymouth', 102, 9341, 'NA', '.ms', 'XCD', 'Dollar', '+1-664', '', '', 'en-MS', 3578097, ''),
('Malta', 'MT', 'MLT', 470, 'MT', 'Valletta', 316, 403000, 'EU', '.mt', 'EUR', 'Euro', '356', '@@@ ###|@@@ ##', '^([A-Z]{3}\\d{2}\\d?)$', 'mt,en-MT', 2562770, ''),
('Mauritius', 'MU', 'MUS', 480, 'MP', 'Port Louis', 2040, 1294104, 'AF', '.mu', 'MUR', 'Rupee', '230', '', '', 'en-MU,bho,fr', 934292, ''),
('Maldives', 'MV', 'MDV', 462, 'MV', 'Male', 300, 395650, 'AS', '.mv', 'MVR', 'Rufiyaa', '960', '#####', '^(\\d{5})$', 'dv,en', 1282028, ''),
('Malawi', 'MW', 'MWI', 454, 'MI', 'Lilongwe', 118480, 15447500, 'AF', '.mw', 'MWK', 'Kwacha', '265', '', '', 'ny,yao,tum,swk', 927384, 'TZ,MZ,ZM'),
('Mexico', 'MX', 'MEX', 484, 'MX', 'Mexico City', 1972550, 112468855, 'NA', '.mx', 'MXN', 'Peso', '52', '#####', '^(\\d{5})$', 'es-MX', 3996063, 'GT,US,BZ'),
('Malaysia', 'MY', 'MYS', 458, 'MY', 'Kuala Lumpur', 329750, 28274729, 'AS', '.my', 'MYR', 'Ringgit', '60', '#####', '^(\\d{5})$', 'ms-MY,en,zh,ta,te,ml,pa,th', 1733045, 'BN,TH,ID'),
('Mozambique', 'MZ', 'MOZ', 508, 'MZ', 'Maputo', 801590, 22061451, 'AF', '.mz', 'MZN', 'Metical', '258', '####', '^(\\d{4})$', 'pt-MZ,vmw', 1036973, 'ZW,TZ,SZ,ZA,ZM,MW'),
('Namibia', 'NA', 'NAM', 516, 'WA', 'Windhoek', 825418, 2128471, 'AF', '.na', 'NAD', 'Dollar', '264', '', '', 'en-NA,af,de,hz,naq', 3355338, 'ZA,BW,ZM,AO'),
('New Caledonia', 'NC', 'NCL', 540, 'NC', 'Noumea', 19060, 216494, 'OC', '.nc', 'XPF', 'Franc', '687', '#####', '^(\\d{5})$', 'fr-NC', 2139685, ''),
('Niger', 'NE', 'NER', 562, 'NG', 'Niamey', 1267000, 15878271, 'AF', '.ne', 'XOF', 'Franc', '227', '####', '^(\\d{4})$', 'fr-NE,ha,kr,dje', 2440476, 'TD,BJ,DZ,LY,BF,NG,ML'),
('Norfolk Island', 'NF', 'NFK', 574, 'NF', 'Kingston', 35, 1828, 'OC', '.nf', 'AUD', 'Dollar', '672', '', '', 'en-NF', 2155115, ''),
('Nigeria', 'NG', 'NGA', 566, 'NI', 'Abuja', 923768, 154000000, 'AF', '.ng', 'NGN', 'Naira', '234', '######', '^(\\d{6})$', 'en-NG,ha,yo,ig,ff', 2328926, 'TD,NE,BJ,CM'),
('Nicaragua', 'NI', 'NIC', 558, 'NU', 'Managua', 129494, 5995928, 'NA', '.ni', 'NIO', 'Cordoba', '505', '###-###-#', '^(\\d{7})$', 'es-NI,en', 3617476, 'CR,HN'),
('Netherlands', 'NL', 'NLD', 528, 'NL', 'Amsterdam', 41526, 16645000, 'EU', '.nl', 'EUR', 'Euro', '31', '#### @@', '^(\\d{4}[A-Z]{2})$', 'nl-NL,fy-NL', 2750405, 'DE,BE'),
('Norway', 'NO', 'NOR', 578, 'NO', 'Oslo', 324220, 4985870, 'EU', '.no', 'NOK', 'Krone', '47', '####', '^(\\d{4})$', 'no,nb,nn,se,fi', 3144096, 'FI,RU,SE'),
('Nepal', 'NP', 'NPL', 524, 'NP', 'Kathmandu', 140800, 28951852, 'AS', '.np', 'NPR', 'Rupee', '977', '#####', '^(\\d{5})$', 'ne,en', 1282988, 'CN,IN'),
('Nauru', 'NR', 'NRU', 520, 'NR', 'Yaren', 21, 10065, 'OC', '.nr', 'AUD', 'Dollar', '674', '', '', 'na,en-NR', 2110425, ''),
('Niue', 'NU', 'NIU', 570, 'NE', 'Alofi', 260, 2166, 'OC', '.nu', 'NZD', 'Dollar', '683', '', '', 'niu,en-NU', 4036232, ''),
('New Zealand', 'NZ', 'NZL', 554, 'NZ', 'Wellington', 268680, 4252277, 'OC', '.nz', 'NZD', 'Dollar', '64', '####', '^(\\d{4})$', 'en-NZ,mi', 2186224, ''),
('Oman', 'OM', 'OMN', 512, 'MU', 'Muscat', 212460, 2967717, 'AS', '.om', 'OMR', 'Rial', '968', '###', '^(\\d{3})$', 'ar-OM,en,bal,ur', 286963, 'SA,YE,AE'),
('Panama', 'PA', 'PAN', 591, 'PM', 'Panama City', 78200, 3410676, 'NA', '.pa', 'PAB', 'Balboa', '507', '', '', 'es-PA,en', 3703430, 'CR,CO'),
('Peru', 'PE', 'PER', 604, 'PE', 'Lima', 1285220, 29907003, 'SA', '.pe', 'PEN', 'Sol', '51', '', '', 'es-PE,qu,ay', 3932488, 'EC,CL,BO,BR,CO'),
('French Polynesia', 'PF', 'PYF', 258, 'FP', 'Papeete', 4167, 270485, 'OC', '.pf', 'XPF', 'Franc', '689', '#####', '^((97)|(98)7\\d{2})$', 'fr-PF,ty', 4030656, ''),
('Papua New Guinea', 'PG', 'PNG', 598, 'PP', 'Port Moresby', 462840, 6064515, 'OC', '.pg', 'PGK', 'Kina', '675', '###', '^(\\d{3})$', 'en-PG,ho,meu,tpi', 2088628, 'ID'),
('Philippines', 'PH', 'PHL', 608, 'RP', 'Manila', 300000, 99900177, 'AS', '.ph', 'PHP', 'Peso', '63', '####', '^(\\d{4})$', 'tl,en-PH,fil', 1694008, ''),
('Pakistan', 'PK', 'PAK', 586, 'PK', 'Islamabad', 803940, 184404791, 'AS', '.pk', 'PKR', 'Rupee', '92', '#####', '^(\\d{5})$', 'ur-PK,en-PK,pa,sd,ps,brh', 1168579, 'CN,AF,IR,IN'),
('Poland', 'PL', 'POL', 616, 'PL', 'Warsaw', 312685, 38500000, 'EU', '.pl', 'PLN', 'Zloty', '48', '##-###', '^(\\d{5})$', 'pl', 798544, 'DE,LT,SK,CZ,BY,UA,RU'),
('Saint Pierre and Miquelon', 'PM', 'SPM', 666, 'SB', 'Saint-Pierre', 242, 7012, 'NA', '.pm', 'EUR', 'Euro', '508', '#####', '^(97500)$', 'fr-PM', 3424932, ''),
('Pitcairn', 'PN', 'PCN', 612, 'PC', 'Adamstown', 47, 46, 'OC', '.pn', 'NZD', 'Dollar', '870', '', '', 'en-PN', 4030699, ''),
('Puerto Rico', 'PR', 'PRI', 630, 'RQ', 'San Juan', 9104, 3916632, 'NA', '.pr', 'USD', 'Dollar', '+1-787 and', '#####-####', '^(\\d{9})$', 'en-PR,es-PR', 4566966, ''),
('Palestinian Territory', 'PS', 'PSE', 275, 'WE', 'East Jerusalem', 5970, 3800000, 'AS', '.ps', 'ILS', 'Shekel', '970', '', '', 'ar-PS', 6254930, 'JO,IL'),
('Portugal', 'PT', 'PRT', 620, 'PO', 'Lisbon', 92391, 10676000, 'EU', '.pt', 'EUR', 'Euro', '351', '####-###', '^(\\d{7})$', 'pt-PT,mwl', 2264397, 'ES'),
('Palau', 'PW', 'PLW', 585, 'PS', 'Melekeok', 458, 19907, 'OC', '.pw', 'USD', 'Dollar', '680', '96940', '^(96940)$', 'pau,sov,en-PW,tox,ja,fil,zh', 1559582, ''),
('Paraguay', 'PY', 'PRY', 600, 'PA', 'Asuncion', 406750, 6375830, 'SA', '.py', 'PYG', 'Guarani', '595', '####', '^(\\d{4})$', 'es-PY,gn', 3437598, 'BO,BR,AR'),
('Qatar', 'QA', 'QAT', 634, 'QA', 'Doha', 11437, 840926, 'AS', '.qa', 'QAR', 'Rial', '974', '', '', 'ar-QA,es', 289688, 'SA'),
('Reunion', 'RE', 'REU', 638, 'RE', 'Saint-Denis', 2517, 776948, 'AF', '.re', 'EUR', 'Euro', '262', '#####', '^((97)|(98)(4|7|8)\\d{2})$', 'fr-RE', 935317, ''),
('Romania', 'RO', 'ROU', 642, 'RO', 'Bucharest', 237500, 21959278, 'EU', '.ro', 'RON', 'Leu', '40', '######', '^(\\d{6})$', 'ro,hu,rom', 798549, 'MD,HU,UA,CS,BG,RS'),
('Serbia', 'RS', 'SRB', 688, 'RI', 'Belgrade', 88361, 7344847, 'EU', '.rs', 'RSD', 'Dinar', '381', '######', '^(\\d{6})$', 'sr,hu,bs,rom', 6290252, 'AL,HU,MK,RO,HR,BA,BG,ME,XK'),
('Russia', 'RU', 'RUS', 643, 'RS', 'Moscow', 17100000, 140702000, 'EU', '.ru', 'RUB', 'Ruble', '7', '######', '^(\\d{6})$', 'ru,tt,xal,cau,ady,kv,ce,tyv,cv,udm,tut,mns,bua,myv,mdf,chm,ba,inh,tut,kbd,krc,ava,sah,nog', 2017370, 'GE,CN,BY,UA,KZ,LV,PL,EE,LT,FI,MN,NO,AZ,KP'),
('Rwanda', 'RW', 'RWA', 646, 'RW', 'Kigali', 26338, 11055976, 'AF', '.rw', 'RWF', 'Franc', '250', '', '', 'rw,en-RW,fr-RW,sw', 49518, 'TZ,CD,BI,UG'),
('Saudi Arabia', 'SA', 'SAU', 682, 'SA', 'Riyadh', 1960582, 25731776, 'AS', '.sa', 'SAR', 'Rial', '966', '#####', '^(\\d{5})$', 'ar-SA', 102358, 'QA,OM,IQ,YE,JO,AE,KW'),
('Solomon Islands', 'SB', 'SLB', 90, 'BP', 'Honiara', 28450, 559198, 'OC', '.sb', 'SBD', 'Dollar', '677', '', '', 'en-SB,tpi', 2103350, ''),
('Seychelles', 'SC', 'SYC', 690, 'SE', 'Victoria', 455, 88340, 'AF', '.sc', 'SCR', 'Rupee', '248', '', '', 'en-SC,fr-SC', 241170, ''),
('Sudan', 'SD', 'SDN', 729, 'SU', 'Khartoum', 1861484, 35000000, 'AF', '.sd', 'SDG', 'Pound', '249', '#####', '^(\\d{5})$', 'ar-SD,en,fia', 366755, 'SS,TD,EG,ET,ER,LY,CF'),
('South Sudan', 'SS', 'SSD', 728, 'OD', 'Juba', 644329, 8260490, 'AF', '', 'SSP', 'Pound', '211', '', '', 'en', 7909807, 'CD,CF,ET,KE,SD,UG,'),
('Sweden', 'SE', 'SWE', 752, 'SW', 'Stockholm', 449964, 9045000, 'EU', '.se', 'SEK', 'Krona', '46', 'SE-### ##', '^(?:SE)*(\\d{5})$', 'sv-SE,se,sma,fi-SE', 2661886, 'NO,FI'),
('Singapore', 'SG', 'SGP', 702, 'SN', 'Singapur', 693, 4701069, 'AS', '.sg', 'SGD', 'Dollar', '65', '######', '^(\\d{6})$', 'cmn,en-SG,ms-SG,ta-SG,zh-SG', 1880251, ''),
('Saint Helena', 'SH', 'SHN', 654, 'SH', 'Jamestown', 410, 7460, 'AF', '.sh', 'SHP', 'Pound', '290', 'STHL 1ZZ', '^(STHL1ZZ)$', 'en-SH', 3370751, ''),
('Slovenia', 'SI', 'SVN', 705, 'SI', 'Ljubljana', 20273, 2007000, 'EU', '.si', 'EUR', 'Euro', '386', 'SI- ####', '^(?:SI)*(\\d{4})$', 'sl,sh', 3190538, 'HU,IT,HR,AT'),
('Svalbard and Jan Mayen', 'SJ', 'SJM', 744, 'SV', 'Longyearbyen', 62049, 2550, 'EU', '.sj', 'NOK', 'Krone', '47', '', '', 'no,ru', 607072, ''),
('Slovakia', 'SK', 'SVK', 703, 'LO', 'Bratislava', 48845, 5455000, 'EU', '.sk', 'EUR', 'Euro', '421', '###  ##', '^(\\d{5})$', 'sk,hu', 3057568, 'PL,HU,CZ,UA,AT'),
('Sierra Leone', 'SL', 'SLE', 694, 'SL', 'Freetown', 71740, 5245695, 'AF', '.sl', 'SLL', 'Leone', '232', '', '', 'en-SL,men,tem', 2403846, 'LR,GN'),
('San Marino', 'SM', 'SMR', 674, 'SM', 'San Marino', 61, 31477, 'EU', '.sm', 'EUR', 'Euro', '378', '4789#', '^(4789\\d)$', 'it-SM', 3168068, 'IT'),
('Senegal', 'SN', 'SEN', 686, 'SG', 'Dakar', 196190, 12323252, 'AF', '.sn', 'XOF', 'Franc', '221', '#####', '^(\\d{5})$', 'fr-SN,wo,fuc,mnk', 2245662, 'GN,MR,GW,GM,ML'),
('Somalia', 'SO', 'SOM', 706, 'SO', 'Mogadishu', 637657, 10112453, 'AF', '.so', 'SOS', 'Shilling', '252', '@@  #####', '^([A-Z]{2}\\d{5})$', 'so-SO,ar-SO,it,en-SO', 51537, 'ET,KE,DJ'),
('Suriname', 'SR', 'SUR', 740, 'NS', 'Paramaribo', 163270, 492829, 'SA', '.sr', 'SRD', 'Dollar', '597', '', '', 'nl-SR,en,srn,hns,jv', 3382998, 'GY,BR,GF'),
('Sao Tome and Principe', 'ST', 'STP', 678, 'TP', 'Sao Tome', 1001, 175808, 'AF', '.st', 'STD', 'Dobra', '239', '', '', 'pt-ST', 2410758, ''),
('El Salvador', 'SV', 'SLV', 222, 'ES', 'San Salvador', 21040, 6052064, 'NA', '.sv', 'USD', 'Dollar', '503', 'CP ####', '^(?:CP)*(\\d{4})$', 'es-SV', 3585968, 'GT,HN'),
('Sint Maarten', 'SX', 'SXM', 534, 'NN', 'Philipsburg', 0, 37429, 'NA', '.sx', 'ANG', 'Guilder', '599', '', '', 'nl,en', 7609695, 'MF'),
('Syria', 'SY', 'SYR', 760, 'SY', 'Damascus', 185180, 22198110, 'AS', '.sy', 'SYP', 'Pound', '963', '', '', 'ar-SY,ku,hy,arc,fr,en', 163843, 'IQ,JO,IL,TR,LB'),
('Swaziland', 'SZ', 'SWZ', 748, 'WZ', 'Mbabane', 17363, 1354051, 'AF', '.sz', 'SZL', 'Lilangeni', '268', '@###', '^([A-Z]\\d{3})$', 'en-SZ,ss-SZ', 934841, 'ZA,MZ'),
('Turks and Caicos Islands', 'TC', 'TCA', 796, 'TK', 'Cockburn Town', 430, 20556, 'NA', '.tc', 'USD', 'Dollar', '+1-649', 'TKCA 1ZZ', '^(TKCA 1ZZ)$', 'en-TC', 3576916, ''),
('Chad', 'TD', 'TCD', 148, 'CD', 'N''Djamena', 1284000, 10543464, 'AF', '.td', 'XAF', 'Franc', '235', '', '', 'fr-TD,ar-TD,sre', 2434508, 'NE,LY,CF,SD,CM,NG'),
('French Southern Territories', 'TF', 'ATF', 260, 'FS', 'Port-aux-Francais', 7829, 140, 'AN', '.tf', 'EUR', 'Euro  ', '', '', '', 'fr', 1546748, ''),
('Togo', 'TG', 'TGO', 768, 'TO', 'Lome', 56785, 6587239, 'AF', '.tg', 'XOF', 'Franc', '228', '', '', 'fr-TG,ee,hna,kbp,dag,ha', 2363686, 'BJ,GH,BF'),
('Thailand', 'TH', 'THA', 764, 'TH', 'Bangkok', 514000, 67089500, 'AS', '.th', 'THB', 'Baht', '66', '#####', '^(\\d{5})$', 'th,en', 1605651, 'LA,MM,KH,MY'),
('Tajikistan', 'TJ', 'TJK', 762, 'TI', 'Dushanbe', 143100, 7487489, 'AS', '.tj', 'TJS', 'Somoni', '992', '######', '^(\\d{6})$', 'tg,ru', 1220409, 'CN,AF,KG,UZ'),
('Tokelau', 'TK', 'TKL', 772, 'TL', '', 10, 1466, 'OC', '.tk', 'NZD', 'Dollar', '690', '', '', 'tkl,en-TK', 4031074, ''),
('East Timor', 'TL', 'TLS', 626, 'TT', 'Dili', 15007, 1154625, 'OC', '.tl', 'USD', 'Dollar', '670', '', '', 'tet,pt-TL,id,en', 1966436, 'ID'),
('Turkmenistan', 'TM', 'TKM', 795, 'TX', 'Ashgabat', 488100, 4940916, 'AS', '.tm', 'TMT', 'Manat', '993', '######', '^(\\d{6})$', 'tk,ru,uz', 1218197, 'AF,IR,UZ,KZ'),
('Tunisia', 'TN', 'TUN', 788, 'TS', 'Tunis', 163610, 10589025, 'AF', '.tn', 'TND', 'Dinar', '216', '####', '^(\\d{4})$', 'ar-TN,fr', 2464461, 'DZ,LY'),
('Tonga', 'TO', 'TON', 776, 'TN', 'Nuku''alofa', 748, 122580, 'OC', '.to', 'TOP', 'Pa''anga', '676', '', '', 'to,en-TO', 4032283, ''),
('Turkey', 'TR', 'TUR', 792, 'TU', 'Ankara', 780580, 77804122, 'AS', '.tr', 'TRY', 'Lira', '90', '#####', '^(\\d{5})$', 'tr-TR,ku,diq,az,av', 298795, 'SY,GE,IQ,IR,GR,AM,AZ,BG'),
('Trinidad and Tobago', 'TT', 'TTO', 780, 'TD', 'Port of Spain', 5128, 1228691, 'NA', '.tt', 'TTD', 'Dollar', '+1-868', '', '', 'en-TT,hns,fr,es,zh', 3573591, ''),
('Tuvalu', 'TV', 'TUV', 798, 'TV', 'Funafuti', 26, 10472, 'OC', '.tv', 'AUD', 'Dollar', '688', '', '', 'tvl,en,sm,gil', 2110297, ''),
('Taiwan', 'TW', 'TWN', 158, 'TW', 'Taipei', 35980, 22894384, 'AS', '.tw', 'TWD', 'Dollar', '886', '#####', '^(\\d{5})$', 'zh-TW,zh,nan,hak', 1668284, ''),
('Tanzania', 'TZ', 'TZA', 834, 'TZ', 'Dodoma', 945087, 41892895, 'AF', '.tz', 'TZS', 'Shilling', '255', '', '', 'sw-TZ,en,ar', 149590, 'MZ,KE,CD,RW,ZM,BI,UG,MW'),
('Ukraine', 'UA', 'UKR', 804, 'UP', 'Kiev', 603700, 45415596, 'EU', '.ua', 'UAH', 'Hryvnia', '380', '#####', '^(\\d{5})$', 'uk,ru-UA,rom,pl,hu', 690791, 'PL,MD,HU,SK,BY,RO,RU'),
('Uganda', 'UG', 'UGA', 800, 'UG', 'Kampala', 236040, 33398682, 'AF', '.ug', 'UGX', 'Shilling', '256', '', '', 'en-UG,lg,sw,ar', 226074, 'TZ,KE,SS,CD,RW'),
('United States Minor Outlying Islands', 'UM', 'UMI', 581, '', '', 0, 0, 'OC', '.um', 'USD', 'Dollar ', '1', '', '', 'en-UM', 5854968, ''),
('United States', 'US', 'USA', 840, 'US', 'Washington', 9629091, 310232863, 'NA', '.us', 'USD', 'Dollar', '1', '#####-####', '^(\\d{9})$', 'en-US,es-US,haw,fr', 6252001, 'CA,MX,CU'),
('Uruguay', 'UY', 'URY', 858, 'UY', 'Montevideo', 176220, 3477000, 'SA', '.uy', 'UYU', 'Peso', '598', '#####', '^(\\d{5})$', 'es-UY', 3439705, 'BR,AR'),
('Uzbekistan', 'UZ', 'UZB', 860, 'UZ', 'Tashkent', 447400, 27865738, 'AS', '.uz', 'UZS', 'Som', '998', '######', '^(\\d{6})$', 'uz,ru,tg', 1512440, 'TM,AF,KG,TJ,KZ'),
('Vatican', 'VA', 'VAT', 336, 'VT', 'Vatican City', 0, 921, 'EU', '.va', 'EUR', 'Euro', '379', '', '', 'la,it,fr', 3164670, 'IT'),
('Saint Vincent and the Grenadines', 'VC', 'VCT', 670, 'VC', 'Kingstown', 389, 104217, 'NA', '.vc', 'XCD', 'Dollar', '+1-784', '', '', 'en-VC,fr', 3577815, ''),
('Venezuela', 'VE', 'VEN', 862, 'VE', 'Caracas', 912050, 27223228, 'SA', '.ve', 'VEF', 'Bolivar', '58', '####', '^(\\d{4})$', 'es-VE', 3625428, 'GY,BR,CO'),
('British Virgin Islands', 'VG', 'VGB', 92, 'VI', 'Road Town', 153, 21730, 'NA', '.vg', 'USD', 'Dollar', '+1-284', '', '', 'en-VG', 3577718, ''),
('U.S. Virgin Islands', 'VI', 'VIR', 850, 'VQ', 'Charlotte Amalie', 352, 108708, 'NA', '.vi', 'USD', 'Dollar', '+1-340', '', '', 'en-VI', 4796775, ''),
('Vietnam', 'VN', 'VNM', 704, 'VM', 'Hanoi', 329560, 89571130, 'AS', '.vn', 'VND', 'Dong', '84', '######', '^(\\d{6})$', 'vi,en,fr,zh,km', 1562822, 'CN,LA,KH'),
('Vanuatu', 'VU', 'VUT', 548, 'NH', 'Port Vila', 12200, 221552, 'OC', '.vu', 'VUV', 'Vatu', '678', '', '', 'bi,en-VU,fr-VU', 2134431, ''),
('Wallis and Futuna', 'WF', 'WLF', 876, 'WF', 'Mata Utu', 274, 16025, 'OC', '.wf', 'XPF', 'Franc', '681', '#####', '^(986\\d{2})$', 'wls,fud,fr-WF', 4034749, ''),
('Samoa', 'WS', 'WSM', 882, 'WS', 'Apia', 2944, 192001, 'OC', '.ws', 'WST', 'Tala', '685', '', '', 'sm,en-WS', 4034894, ''),
('Yemen', 'YE', 'YEM', 887, 'YM', 'Sanaa', 527970, 23495361, 'AS', '.ye', 'YER', 'Rial', '967', '', '', 'ar-YE', 69543, 'SA,OM'),
('Mayotte', 'YT', 'MYT', 175, 'MF', 'Mamoudzou', 374, 159042, 'AF', '.yt', 'EUR', 'Euro', '262', '#####', '^(\\d{5})$', 'fr-YT', 1024031, ''),
('South Africa', 'ZA', 'ZAF', 710, 'SF', 'Pretoria', 1219912, 49000000, 'AF', '.za', 'ZAR', 'Rand', '27', '####', '^(\\d{4})$', 'zu,xh,af,nso,en-ZA,tn,st,ts,ss,ve,nr', 953987, 'ZW,SZ,MZ,BW,NA,LS'),
('Zambia', 'ZM', 'ZMB', 894, 'ZA', 'Lusaka', 752614, 13460305, 'AF', '.zm', 'ZMK', 'Kwacha', '260', '#####', '^(\\d{5})$', 'en-ZM,bem,loz,lun,lue,ny,toi', 895949, 'ZW,TZ,MZ,CD,NA,MW,AO'),
('Zimbabwe', 'ZW', 'ZWE', 716, 'ZI', 'Harare', 390580, 11651858, 'AF', '.zw', 'ZWL', 'Dollar', '263', '', '', 'en-ZW,sn,nr,nd', 878675, 'ZA,MZ,BW,ZM'),
('Serbia and Montenegro', 'CS', 'SCG', 891, 'YI', 'Belgrade', 102350, 10829175, 'EU', '.cs', 'RSD', 'Dinar', '381', '#####', '^(\\d{5})$', 'cu,hu,sq,sr', 0, 'AL,HU,MK,RO,HR,BA,BG'),
('Netherlands Antilles', 'AN', 'ANT', 530, 'NT', 'Willemstad', 960, 136197, 'NA', '.an', 'ANG', 'Guilder', '599', '', '', 'nl-AN,en,es', 0, 'GP');

-- --------------------------------------------------------

--
-- Structure de la table `localized`
--

CREATE TABLE IF NOT EXISTS `localized` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foreign_key` int(11) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `model` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_LOCALIZING` (`model`,`foreign_key`,`place_id`),
  KEY `INDEX_LOCALIZED` (`model`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `localized`
--


-- --------------------------------------------------------

--
-- Structure de la table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `formatted_address` varchar(150) NOT NULL,
  `formatted_phone_number` varchar(50) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `rating` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `places`
--


-- --------------------------------------------------------

--
-- Structure de la table `place_types`
--

CREATE TABLE IF NOT EXISTS `place_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `place_types`
--


-- --------------------------------------------------------

--
-- Structure de la table `place_types_places`
--

CREATE TABLE IF NOT EXISTS `place_types_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_type_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `place_types_places`
--

