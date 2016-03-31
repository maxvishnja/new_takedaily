<?php
return [
	'back'         => '&lsaquo; Tilbage til tidligere spørgsmål',
	'scripts'      => 'Venligst aktiver javascripts!',
	'steps'        => [
		'one'   => 'PERSONLIGT',
		'two'   => 'HELBRED',
		'three' => 'KOST OG VANER',
		'four'  => 'ANBEFALING'
	],
	'questions'    => [
		'1-1' => [
			'title'   => 'Hvilket køn er du?',
			'text'    => 'Mænd og kvinder har ikke brug for den samme mængde vitaminer og mineraler. Fx har store knogler og stærke muskler brug for mere D-vitamin.',
			'options' => [
				'1' => 'Mand',
				'2' => 'Kvinde'
			]
		],
		'1-2' => [
			'title'              => 'Hvor gammel er du?',
			'title-alt'          => 'Vi ved det godt. Man spørger ikke en kvinde om hendes alder, men vi lover, vi ikke siger det til nogen.',
			'text'               => 'Når du bliver ældre, får din krop brug for mere D-vitamin, B12-vitamin og kalk end tidligere. Du har brug for B12-vitaminet til at danne røde blodlegemer. Vitaminet er godt mod demens og sikrer, at dit nervesystem fungerer optimalt.',
			'button-text'        => 'Vælg din fødselsdagsdato',
			'button-submit-text' => 'Ja, jeg er <strong>{{ temp_age }}</strong> år gammel'
		],
		'1-3' => [
			'title'   => 'Hvilken hudfarve matcher din bedst?',
			'text'    => 'Er du meget lys i huden, kan du producere mere D-vitamin, når du opholder dig i solen, end hvis din hud er mørk. Så har du ikke en helt lys hudfarve, kan du have brug for D-vitamin-tilskud.',
			'options' => [
				'1' => 'Lys',
				'2' => 'Mørk',
				'3' => 'Sort'
			]
		],
		'1-4' => [
			'title'   => 'Er du udenfor hver dag, efter solen er stået op, og før den går ned?',
			'text'    => 'Du skal være udenfor i 15-30 minutter hver dag, hvis du vil være sikker på, at din krop producerer D-vitamin nok. Har du en langærmet trøje og lange bukser på, tæller turen i det fri ikke, hvis målet er at få nok D-vitamin.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-1' => [
			'title'   => 'Er du gravid, eller drømmer du om at blive det?',
			'text'    => 'Nogle vitaminer og mineraler skal du have flere af, når du er gravid eller gerne vil være det.
							Sundhedsstyrelsen anbefaler, at du tager tilskud af folsyre, som er et B-vitamin, allerede fra du tænker på at blive gravid til 12
							uger inde i graviditeten. Folsyre er vigtigt, når barnets centralnervesystem udvikles.
							<br/><br/>
							Gennem hele graviditeten er det en god idé at tage fiskeolie. Det er godt for både barnet og dig.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-2' => [
			'title'   => 'Er du på slankekur?',
			'text'    => 'Når din kost bliver mere fedtfattig, bliver den måske også mere ensidig, end den plejer. Og så er det vigtigt, at du stadig får de vitaminer og mineraler, som du måske normalt indtager igennem din kost. A-vitamin er godt for din hud og dit immunsystem. Mens C-vitamin øger kroppens evne til at nedbryde fedt. Så ingen af delene skal du have for lidt af, når du gerne vil tabe nogle kilo.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-3' => [
			'title'   => 'Hvor meget og hvor ofte motionerer du?',
			'text'    => 'Motion er både godt for din sundhed og dit velbefindende. Hvis du dyrker meget motion, har du brug for nogle ekstra vitaminer og mineraler. B-vitamin sørger fx for, at du kan præstere mere ved højintensitetstræning og er med til at producere og reparere celler. Jern er også vigtigt, når du motionerer meget. Det sørger nemlig for, at ilten transporteres rundt i kroppen.',
			'options' => [
				'1' => 'Sjældent',
				'2' => 'Én gang om ugen',
				'3' => 'To gange om ugen',
				'4' => 'Oftere'
			]
		],
		'2-4' => [
			'title'   => 'Hvordan har du det, når dagen er slut?',
			'text'    => 'I en stresset periode har du brug for lidt ekstra vitaminer, som kan hjælpe dig med at slappe mere af. B-vitamin giver ro på og hjælper dit nervesystem og immunforsvar med at fungere optimalt.',
			'options' => [
				'1' => 'Jeg føler mig lidt stresset',
				'2' => 'Jeg har det fint og er naturligt træt'
			]
		],
		'2-5' => [
			'title'   => 'Føler du dig tit træt, eller mangler du energi?',
			'text'    => 'B-vitaminerne (B1, B2 , B3, B5 og B6) spiller en afgørende rolle for dit energiniveau. Mangler du de vitaminer, kan du føle dig træt og savne energi.',
			'options' => [
				'1' => 'Hver dag',
				'2' => 'Af og til',
				'3' => 'Aldrig'
			]
		],
		'2-6' => [
			'title'   => 'Vil du gerne styrke dit immunforsvar?',
			'text'    => 'De rigtige vitaminer kan styrke dit immunforsvar. C-vitamin er en antioxidant og vigtigt for dit
							immunforsvar, fordi det hjælper kroppen med at producere hvide blodlegemer. Men også A- og D-vitamin er gavnlige, hvis du gerne vil
							undgå at blive syg.',
			'options' => [
				'1' => 'Ja, jeg vil gerne beskyttes bedre',
				'2' => 'Nej, det behøver jeg ikke'
			]
		],
		'2-7' => [
			'title'   => 'Ryger du?',
			'text'    => 'Det er videnskabeligt bevist, at behovet for C-vitamin er større, hvis du ryger, fordi tobaksrøg ilter og
							ødelægger vitaminet.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-8' => [
			'title'   => 'Spiser du som en kanin?',
			'text'    => 'Kød indeholder masser af jern, B1- og B12-vitamin. Begge vitaminer er vigtige komponenter i dit
							energistofskifte. B1 omsætter fx kulhydrat til druesukker. Når druesukker forbrændes i kroppen skabes energi.',
			'options' => [
				'1' => 'Ja, jeg er vegetar',
				'2' => 'Nej, jeg spiser også kød og fisk'
			]
		],
		'2-9' => [
			'title'   => 'Har du ømme muskler eller ondt i dine led?',
			'text'    => 'Nogle næringsstoffer er gode for dine led og muskler. Mangel på D-vitamin kan ligefrem give svage muskler
							og muskelsmerter.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-10' => [
			'title'   => 'Tager du allerede vitaminer og/eller mineraler?',
			'text'    => 'Testresultatet er baseret på din kost og din livsstil. Take Daily sørger for, at du får alle de vitaminer
							og mineraler, du har brug for. Du skal derfor ikke bekymre dig om at tage andre tilskud.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'3-1' => [
			'title'   => 'Hvor mange grønsager spiser du dagligt?',
			'text'    => 'Grøntsager er en vigtig kilde til C-vitamin, folsyre og kalium.',
			'options' => [
				'1' => 'Ingen',
				'2' => '1 portion (50 gram)',
				'3' => '2 portioner (100 gram)',
				'4' => '3 portioner (150 gram)',
				'5' => '+4 portioner (+200 gram)'
			]
		],
		'3-2' => [
			'title'   => 'Hvor meget frugt spiser/drikker du om dagen?',
			'text'    => 'Frugt er en vigtig kilde til C-vitamin. Frugtjuice kan kun tælle for ét stykke frugt om dagen. Så du kan
							fint nøjes med et enkelt glas.',
			'options' => [
				'1' => 'Intet',
				'2' => '1 stk. / glas',
				'3' => '2 stk. / glas'
			]
		],
		'3-3' => [
			'title'   => 'Hvor mange skiver brød spiser du om dagen?',
			'text'    => 'Havregrød eller lign. tæller for én skive brød.<br/><br/>Brød er en vigtig kilde til B-vitamin, jern og kostfibre. Vælg fuldkorn. Det mætter rigtig godt. Det får
							dig til at spise mindre og gør det lettere at holde vægten. B-vitamin og jern fra brødet giver dig energi.',
			'options' => [
				'1' => 'Intet',
				'2' => '1-2 stk.',
				'3' => '3-4 stk.',
				'4' => '5-6 stk.',
				'5' => '+7 stk.'
			]
		],
		'3-4' => [
			'title'   => 'Kommer du smør på brødet eller bruger du margarine, smør eller olie, når du laver mad?',
			'text'    => 'Smør, margarine og olie er vigtige kilder til A-vitamin og D-vitamin. Du har brug for begge vitaminer.
							Blandt immunforsvar.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej',
				'3' => 'Nogle gange'
			]
		],
		'3-5' => [
			'title'   => 'Hvor mange portioner pasta, ris, kartofler, couscous, quinoa og lignede spiser du om dagen?',
			'text'    => 'Pasta, ris, kartofler og lignende er fyldt med gode kulhydrater og indeholder næsten ingen fedt. Og så er
							de en vigtig kilde til B-vitamin og mineraler.',
			'options' => [
				'1' => 'Ingen',
				'2' => '1-2 portioner (50-100 gram)',
				'3' => '3-4 portioner (150-200 gram)',
				'4' => '+5 portioner (+250 gram)'
			]
		],
		'3-6' => [
			'title'   => 'Hvor meget kød spiser du om dagen?',
			'text'    => 'Kød er en vigtig kilde til B-vitaminer (fx B6 og B12) og mineralerne zink, selen og jern.',
			'options' => [
				'1' => '0-75 gram',
				'2' => '76-150 gram',
				'3' => '+150 gram'
			]
		],
		'3-7' => [
			'title'   => 'Hvor ofte spiser du fisk?',
			'text'    => 'Fisk indeholder sunde fiskeolier som fx omega-3 fedtsyre og vitaminer som D-vitamin, jod og selen.',
			'options' => [
				'1' => 'Aldrig / sjældent',
				'2' => 'En gang om ugen',
				'3' => 'To, eller flere, gange om ugen'
			]
		],
		'3-8' => [
			'title'   => 'Hvor meget mælk drikker du om dagen?',
			'text'    => 'Mejeriprodukter indeholder vigtige næringsstoffer, blandt andet protein, B2-vitamin, B12-vitamin,
							kalcium, fosfor og jod. Kalcium er godt for knoglerne, men hvor mange mejeriprodukter du har brug for, afhænger af din alder.',
			'options' => [
				'1' => 'Ingen',
				'2' => '1-2 glas',
				'3' => '+3 glas'
			]
		]
	],
	'combinations' => [

	],
	'call-me'      => [
		'title'       => 'Har du ikke tid til at udfylde formularen?',
		'text'        => 'Bliv ringet op, indtast dit tlf. nummer og vælg tidspunkt.',
		'button-text' => 'Ring mig op',
		'deny'        => 'Ellers tak. Luk besked.',
		'options'     => [
			'09:00 - 11:00',
			'11:00 - 13:00',
			'13:00 - 15:00',
			'15:00 - 17:00'
		]
	],
	'datepicker'   => [
		'months_long'  => [
			'1'  => 'Januar',
			'2'  => 'Februar',
			'3'  => 'Marts',
			'4'  => 'April',
			'5'  => 'Maj',
			'6'  => 'Juni',
			'7'  => 'Juli',
			'8'  => 'August',
			'9'  => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'December'
		],
		'months_short' => [
			'1'  => 'Jan',
			'2'  => 'Feb',
			'3'  => 'Mar',
			'4'  => 'Apr',
			'5'  => 'Maj',
			'6'  => 'Jun',
			'7'  => 'Jul',
			'8'  => 'Aug',
			'9'  => 'Sep',
			'10' => 'Okt',
			'11' => 'Nov',
			'12' => 'Dec'
		],
		'days_long'    => [
			'1' => 'Søndag',
			'2' => 'Mandag',
			'3' => 'Tirsdag',
			'4' => 'Onsdag',
			'5' => 'Torsdag',
			'6' => 'Fredag',
			'7' => 'Lørdag'
		],
		'days_short'   => [
			'1' => 'Søn',
			'2' => 'Man',
			'3' => 'Tir',
			'4' => 'Ons',
			'5' => 'Tor',
			'6' => 'Fre',
			'7' => 'Lør'
		],
		'buttons'      => [
			'clear'        => 'Nulstil',
			'close'        => 'Luk',
			'next-month'   => 'Næste måned',
			'prev-month'   => 'Tidligere måned',
			'select-month' => 'Vælg måned',
			'select-year'  => 'Vælg årstal',
		]
	]
];