<?php
namespace Database\Seeders;
use App\Models\Events;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BibleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = "INSERT INTO `bible_books` (`book_id`, `english_book`, `tamil_book`, `chapter_count`) VALUES
			(1,	'Genesis',	'ஆதியாகமம்',	50),
			(2,	'Exodus',	'யாத்திராகமம்',	40),
			(3,	'Leviticus',	'லேவியராகமம்',	27),
			(4,	'Numbers',	'எண்ணாகமம்',	36),
			(5,	'Deuteronomy',	'உபாகமம்',	34),
			(6,	'Joshua',	'யோசுவா',	24),
			(7,	'Judges',	'நியாயாதிபதிகள்',	21),
			(8,	'Ruth',	'ரூத்',	4),
			(9,	'1 Samuel',	'1 சாமுவேல்',	31),
			(10,	'2 Samuel',	'2 சாமுவேல்',	24),
			(11,	'1 Kings',	'1 இராஜாக்கள்',	22),
			(12,	'2 Kings',	'2 இராஜாக்கள்',	25),
			(13,	'1 Chronicles',	'1 நாளாகமம்',	29),
			(14,	'2 Chronicles',	'2 நாளாகமம்',	36),
			(15,	'Ezra',	'எஸ்றா',	10),
			(16,	'Nehemiah',	'நெகேமியா',	13),
			(17,	'Esther',	'எஸ்தர்',	10),
			(18,	'Job',	'யோபு',	42),
			(19,	'Psalms',	'சங்கீதம்',	150),
			(20,	'Proverbs',	'நீதிமொழிகள்',	31),
			(21,	'Ecclesiastes',	'பிரசங்கி',	12),
			(22,	'The Song of Solomon',	'உன்னதப்பாட்டு',	8),
			(23,	'Isaiah',	'ஏசாயா',	66),
			(24,	'Jeremiah',	'எரேமியா',	52),
			(25,	'Lamentations',	'புலம்பல்',	5),
			(26,	'Ezekiel',	'எசேக்கியேல்',	48),
			(27,	'Daniel',	'தானியேல்',	12),
			(28,	'Hosea',	'ஓசியா',	14),
			(29,	'Joel',	'யோவேல்',	3),
			(30,	'Amos',	'ஆமோஸ்',	9),
			(31,	'Obadiah',	'ஒபதியா',	1),
			(32,	'Jonah',	'யோனா',	4),
			(33,	'Micah',	'மீகா',	7),
			(34,	'Nahum',	'நாகூம்',	3),
			(35,	'Habakkuk',	'ஆபகூக்',	3),
			(36,	'Zephaniah',	'செப்பனியா',	3),
			(37,	'Haggai',	'ஆகாய்',	2),
			(38,	'Zechariah',	'சகரியா',	14),
			(39,	'Malachi',	'மல்கியா',	4),
			(40,	'Matthew',	'மத்தேயு',	28),
			(41,	'Mark',	'மாற்கு',	16),
			(42,	'Luke',	'லூக்கா',	24),
			(43,	'John',	'யோவான்',	21),
			(44,	'Acts',	'அப்போஸ்தலர்',	28),
			(45,	'1 Corinthians',	'ரோமர்',	5),
			(46,	'2 Corinthians',	'1 கொரிந்தியர்',	5),
			(47,	'Romans',	'2 கொரிந்தியர்',	3),
			(48,	'Galatians',	'கலாத்தியர்',	5),
			(49,	'Ephesians',	'எபேசியர்',	1),
			(50,	'Philippians',	'பிலிப்பியர்',	1),
			(51,	'Colossians',	'கொலோசெயர்',	1),
			(52,	'1 Thessalonians',	'1 தெசலோனிக்கேயர்',	16),
			(53,	'2 Thessalonians',	'2 தெசலோனிக்கேயர்',	16),
			(54,	'1 Timothy',	'1 தீமோத்தேயு',	13),
			(55,	'2 Timothy',	'2 தீமோத்தேயு',	6),
			(56,	'Titus',	'தீத்து',	6),
			(57,	'Philemon',	'பிலேமோன்',	4),
			(58,	'Hebrews',	'எபிரெயர்',	4),
			(59,	'James',	'யாக்கோபு',	5),
			(60,	'1 Peter',	'1 பேதுரு',	3),
			(61,	'2 Peter',	'2 பேதுரு',	6),
			(62,	'1 John',	'1 யோவான்',	4),
			(63,	'2 John',	'2 யோவான்',	3),
			(64,	'3 John',	'3 யோவான்',	1),
			(65,	'Judas or Jude',	'யூதா',	13),
			(66,	'Revelation',	'வெளிப்படுத்தின விசேஷம்',	22);";
			\DB::unprepared($sql);
    }
}
