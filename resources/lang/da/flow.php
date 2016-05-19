<?php
return [
	'back'              => '&lsaquo; Tilbage til tidligere spørgsmål',
	'title'             => 'Find din anbefaling - TakeDaily',
	'scripts'           => 'Venligst aktiver javascripts!',
	'steps'             => [
		'one'   => 'PERSONLIGT',
		'two'   => 'HELBRED',
		'three' => 'KOST OG VANER',
		'four'  => 'ANBEFALING'
	],
	'button-order-text' => 'Bestil TakeDaily',
	'questions'         => [
		'1-1'  => [
			'title'   => 'Hvilket køn er du?',
			'text'    => 'Mænd og kvinder har ikke brug for den samme mængde vitaminer og mineraler. Fx har store knogler og stærke muskler brug for mere D-vitamin.',
			'options' => [
				'1' => 'Mand',
				'2' => 'Kvinde'
			]
		],
		'1-2'  => [
			'title'              => 'Hvor gammel er du?',
			'title-alt'          => 'Vi ved det godt. Man spørger ikke en kvinde om hendes alder, men vi lover, vi ikke siger det til nogen.',
			'age'                => 'Din fødselsdag',
			'text'               => 'Når du bliver ældre, får din krop brug for mere D-vitamin, B12-vitamin og kalk end tidligere. Du har brug for B12-vitaminet til at danne røde blodlegemer. Vitaminet er godt mod demens og sikrer, at dit nervesystem fungerer optimalt.',
			'button-text'        => 'Vælg din fødselsdagsdato',
			'button-submit-text' => 'Ja, jeg er <strong>{{ temp_age }}</strong> år gammel'
		],
		'1-3'  => [
			'title'   => 'Hvilken hudfarve matcher din bedst?',
			'text'    => 'Er du meget lys i huden, kan du producere mere D-vitamin, når du opholder dig i solen, end hvis din hud er mørk. Så har du ikke en helt lys hudfarve, kan du have brug for D-vitamin-tilskud.',
			'options' => [
				'1' => 'Hvid / Lys',
				'2' => 'Brun / Mørk',
				'3' => 'Sort / Mørkere'
			]
		],
		'1-4'  => [
			'title'   => 'Er du udenfor hver dag, efter solen er stået op, og før den går ned?',
			'text'    => 'Du skal være udenfor i 15-30 minutter hver dag, hvis du vil være sikker på, at din krop producerer D-vitamin nok. Har du en langærmet trøje og lange bukser på, tæller turen i det fri ikke, hvis målet er at få nok D-vitamin.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-1'  => [
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
		'2-2'  => [
			'title'   => 'Er du på slankekur?',
			'text'    => 'Når din kost bliver mere fedtfattig, bliver den måske også mere ensidig, end den plejer. Og så er det vigtigt, at du stadig får de vitaminer og mineraler, som du måske normalt indtager igennem din kost. A-vitamin er godt for din hud og dit immunsystem. Mens C-vitamin øger kroppens evne til at nedbryde fedt. Så ingen af delene skal du have for lidt af, når du gerne vil tabe nogle kilo.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-3'  => [
			'title'   => 'Hvor meget og hvor ofte motionerer du?',
			'text'    => 'Motion er både godt for din sundhed og dit velbefindende. Hvis du dyrker meget motion, har du brug for nogle ekstra vitaminer og mineraler. B-vitamin sørger fx for, at du kan præstere mere ved højintensitetstræning og er med til at producere og reparere celler. Jern er også vigtigt, når du motionerer meget. Det sørger nemlig for, at ilten transporteres rundt i kroppen.',
			'options' => [
				'1' => 'Sjældent',
				'2' => 'Én gang om ugen',
				'3' => 'To gange om ugen',
				'4' => 'Oftere'
			]
		],
		'2-4'  => [
			'title'   => 'Hvordan har du det, når dagen er slut?',
			'text'    => 'I en stresset periode har du brug for lidt ekstra vitaminer, som kan hjælpe dig med at slappe mere af. B-vitamin giver ro på og hjælper dit nervesystem og immunforsvar med at fungere optimalt.',
			'options' => [
				'1' => 'Jeg føler mig lidt stresset',
				'2' => 'Jeg har det fint og er naturligt træt'
			]
		],
		'2-5'  => [
			'title'   => 'Føler du dig tit træt, eller mangler du energi?',
			'text'    => 'B-vitaminerne (B1, B2 , B3, B5 og B6) spiller en afgørende rolle for dit energiniveau. Mangler du de vitaminer, kan du føle dig træt og savne energi.',
			'options' => [
				'1' => 'Hver dag',
				'2' => 'Af og til',
				'3' => 'Aldrig'
			]
		],
		'2-6'  => [
			'title'   => 'Vil du gerne styrke dit immunforsvar?',
			'text'    => 'De rigtige vitaminer kan styrke dit immunforsvar. C-vitamin er en antioxidant og vigtigt for dit
							immunforsvar, fordi det hjælper kroppen med at producere hvide blodlegemer. Men også A- og D-vitamin er gavnlige, hvis du gerne vil
							undgå at blive syg.',
			'options' => [
				'1' => 'Ja, jeg vil gerne beskyttes bedre',
				'2' => 'Nej, det behøver jeg ikke'
			]
		],
		'2-7'  => [
			'title'   => 'Ryger du?',
			'text'    => 'Det er videnskabeligt bevist, at behovet for C-vitamin er større, hvis du ryger, fordi tobaksrøg ilter og
							ødelægger vitaminet.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'2-8'  => [
			'title'   => 'Spiser du som en kanin?',
			'text'    => 'Kød indeholder masser af jern, B1- og B12-vitamin. Begge vitaminer er vigtige komponenter i dit
							energistofskifte. B1 omsætter fx kulhydrat til druesukker. Når druesukker forbrændes i kroppen skabes energi.',
			'options' => [
				'1' => 'Ja, jeg er vegetar',
				'2' => 'Nej, jeg spiser også kød og fisk'
			]
		],
		'2-9'  => [
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
			'text'    => 'Testresultatet er baseret på din kost og din livsstil. TakeDaily sørger for, at du får alle de vitaminer
							og mineraler, du har brug for. Du skal derfor ikke bekymre dig om at tage andre tilskud.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej'
			]
		],
		'3-1'  => [
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
		'3-2'  => [
			'title'   => 'Hvor meget frugt spiser/drikker du om dagen?',
			'text'    => 'Frugt er en vigtig kilde til C-vitamin. Frugtjuice kan kun tælle for ét stykke frugt om dagen. Så du kan
							fint nøjes med et enkelt glas.',
			'options' => [
				'1' => 'Intet',
				'2' => '1 stk. / glas',
				'3' => '2 stk. / glas'
			]
		],
		'3-3'  => [
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
		'3-4'  => [
			'title'   => 'Kommer du smør på brødet eller bruger du margarine, smør eller olie, når du laver mad?',
			'text'    => 'Smør, margarine og olie er vigtige kilder til A-vitamin og D-vitamin. Du har brug for begge vitaminer.
							Blandt immunforsvar.',
			'options' => [
				'1' => 'Ja',
				'2' => 'Nej',
				'3' => 'Nogle gange'
			]
		],
		'3-5'  => [
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
		'3-6'  => [
			'title'   => 'Hvor meget kød spiser du om dagen?',
			'text'    => 'Kød er en vigtig kilde til B-vitaminer (fx B6 og B12) og mineralerne zink, selen og jern.',
			'options' => [
				'1' => '0-75 gram',
				'2' => '76-150 gram',
				'3' => '+150 gram'
			]
		],
		'3-7'  => [
			'title'   => 'Hvor ofte spiser du fisk?',
			'text'    => 'Fisk indeholder sunde fiskeolier som fx omega-3 fedtsyre og vitaminer som D-vitamin, jod og selen.',
			'options' => [
				'1' => 'Aldrig / sjældent',
				'2' => 'En gang om ugen',
				'3' => 'To, eller flere, gange om ugen'
			]
		],
		'3-8'  => [
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
	'combinations'      => [
		'1'    => [
			'basic'          => 'Med TakeDaily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis',
			'basic-10-d'     => 'Med TakeDaily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis.
							Du skal fx have lidt ekstra D-vitamin pga. <span v-show="( user_data.age >= \'50\' && user_data.age <= \'70\' )">din alder</span>
								<span v-show="( user_data.age >= \'50\'&& user_data.age <= \'70\') && user_data.skin > \'1\'">og</span>
								<span v-show="user_data.skin > \'1\'">mørke hudfarve</span>.
								Det sørger vi for.',
			'basic-10-d-alt' => 'Med TakeDaily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis.
							Du skal fx have lidt ekstra D-vitamin, fordi du ikke kommer så meget ud i solen. Det sørger vi for.',
			'basic-20-d'     => 'Med TakeDaily får du præcis de vitaminer og mineraler, du har brug for – i den helt rette dosis.
							<p>I din alder, har du fx brug for lidt ekstra D-vitamin. Det sørger vi for.'
		],
		'2'    => [
			'A' => 'Du er gravid eller ønsker at blive det. Tillykke! I den søde ventetid, sørger TakeDaily for, at du og din baby får de særlige tilskud, I har brug for.
							<br/><br/>
							Gennem hele graviditeten er det godt for udviklingen af babyens knogler og muskler at tage et tilskud af D-vitamin. Fiskeolie…
							<br/><br/>
							Vi håber, du snart får dit ønske om en baby opfyldt. Mens du prøver at blive gravid, har din krop brug for særlige vitaminer og
							mineraler. Det sørger TakeDaily for.
							<br/><br/>
							Sundhedsstyrelsen anbefaler, at du tager folsyre (B9-vitamin), allerede når du begynder at drømme om en baby. Du skal tage folsyre
							helt fra graviditetens begyndelse, da det har betydning for celledelingen og arvematerialet i kroppens celler. Folsyre nedsætter
							risikoen for alvorlige medfødte misdannelser af hjerne og rygmarv (neuralrørsdefekter).',
			'B' => 'Når du er på slankekur, har du brug for lidt ekstra vitaminer og mineraler. TakeDaily giver dig det helt rigtige miks. Husk også
								at slappe af, sove og dyrke motion.
								<br/><br/>
								Når du har fokus på at spise fedtfattigt, bliver din kost typisk mere ensidig, end den plejer, og så har du brug for et tilskud
								K-vitamin. Det er i det hele taget vigtigt, at du stadig får de vitaminer og mineraler, som du normalt indtager igennem en
								varieret kost. A-vitamin er godt for din hud og dit immunsystem. Mens C-vitamin øger kroppens evne til at nedbryde fedt. Så
								ingen af delene skal du have for lidt af, når du gerne vil tabe nogle kilo. Lidt ekstra B-vitamin sørger for, at du kan præstere
								mere, hvis du træner hårdt, og er også med til at producere og reparere celler.',
			'C' => '<span v-show="user_data.sports == 4">
								Når du motionerer så meget, som du gør lige nu, har du brug for ekstra vitaminer og mineraler. Vi har sammensat lige det, din
								krop har behov for, så den kan yde sit maksimale, når du træner.
								<br/><br/>
								B-vitamin sørger fx for, at du kan præstere mere ved højintensitetstræning og er med til at producere og reparere celler. Jern
								er også vigtigt, når du motionerer meget. Det sørger nemlig for, at ilten transporteres rundt i kroppen.
								</span>
							<span v-show="user_data.lacks_energy < 3 || user_data.stressed == 1">
								Når du føler dig træt og mangler energi, mangler du også B-vitaminer. Både B1, B2 , B3, B5 og B6 spiller en afgørende rolle for
								dit energiniveau.</span>',
			'D' => '<span v-show="user_data.immune_system == 1">
								De rigtige vitaminer kan styrke dit immunforsvar. C-vitamin er en antioxidant og vigtigt for dit immunforsvar, fordi det hjælper
								kroppen med at producere hvide blodlegemer. Men også A- og D-vitamin er gavnlige, hvis du gerne vil undgå at blive syg.
</span>
							<span v-show="user_data.smokes == 1">
								Vi anbefaler selvfølgelig, at du stopper med at ryge. Men så længe du ryger, sørger TakeDaily for, at du får lidt ekstra
								C-vitamin. Det er nemlig videnskabeligt bevist, at behovet for C-vitamin er større, når du ryger, fordi tobaksrøg ilter og
								ødelægger vitaminet. Stopper du med at ryge, så husk at ændre din profil på <a href="/account" target="_blank">Mit Take
									Daily</a>.
</span>
							<span v-show="user_data.vegetarian == 1">
								Kød indeholder masser af jern, B1- og B12-vitamin. Som vegetar kan det være svært at få nok af det hele gennem kosten. Begge
								B-vitaminer er vigtige komponenter i dit energistofskifte. B1 omsætter fx kulhydrat til druesukker, og når druesukker forbrændes
								i kroppen skabes energi.</span>',
			'E' => '
						Når du har ømme muskler og led har du brug for nogle gode næringsstoffer. Mangel på D-vitamin kan ligefrem give svage muskler og
						muskelsmerter. Glukosamin/chonodroitin stimulerer bruskcellerne og er godt, hvis dine led fx er slidte.'
		],
		'3'    => [
			'a' => '<span v-show="user_data.foods.fruits == 1">
						Frugt er en vigtig kilde til C-vitamin. Din krop får ikke nok frugt, og derfor heller ikke nok C-vitamin. TakeDaily sørger for,
						at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
						<br/><br/>
						Begynder du at spise mere frugt, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit TakeDaily</a>. Så
						er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
</span>
					<span v-show="user_data.foods.vegetables == 1">
						Grøntsager er en vigtig kilde til B9-vitamin, C-vitamin, folsyre og kalium. TakeDaily sørger for, at du får det, du behøver –
						og så kan du fortsætte med at spise, som du gør nu.
						<br/><br/>
						Begynder du at spise flere grøntsager, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit Take
							Daily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug
						for.</span>',
			'b' => '<span v-show="user_data.foods.bread == 1">
						Brød er en vigtig kilde til B-vitamin, jern og kostfibre. Du spiser ikke nok brød i hverdagen, så du har brug for lidt ekstra
						B-vitamin og jern. Når du ikke får nok jern, vil du ofte føle dig sløv. TakeDaily giver dig præcis det, der skal til, for at du
						føler dig frisk hver dag.
						<br/><br/>
						Begynder du at spise mere brød, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit TakeDaily</a>. Så
						er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.
</span>
					<span v-show="user_data.foods.wheat == 1">
						Du spiser ikke nok pasta, ris og kartofler, og derfor går din krop glip af gode kulhydrater, som er en vigtig kilde til
						B-vitamin og mineraler. TakeDaily sørger for, at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
						<br/><br/>
						Begynder du at spise mere ris, pasta eller det, der ligner, skal du huske at ændre din profil på
						<a href="/account" target="_blank">Mit TakeDaily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig,
						indeholder lige præcis de doser, du har brug for.</span>',
			'c' => '
						Du får ikke mejerprodukter nok, og derfor heller ikke nok kalcium og B2-vitamin. Begge dele har dine knogler og led brug for. Vi
						sørger for at afstemme din dosis efter din alder. Den har nemlig indflydelse på, hvor meget kalcium og B2-vitamin din krop har
						behov for.
						<br/><br/>
						Begynder du at få flere mejeriprodukter i din daglige kost, skal du huske at ændre din profil på
						<a href="/account" target="_blank">Mit TakeDaily</a>. Så er du sikker på, at de mineraler og vitaminer vi sender til dig,
						indeholder lige præcis de doser, du har brug for.',
			'd' => 'Kød er en vigtig kilde til B-vitaminer (fx B6 og B12) og mineralerne zink, selen og jern. TakeDaily sørger for, at du får det,
							du behøver – og så kan du fortsætte med at spise, som du gør nu.
							<br/><br/>
							Begynder du at spise kød, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit TakeDaily</a>. Så er du
							sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.',
			'e' => '
						Du spiser ikke nok fisk, og derfor bliver din krop snydt for sunde fiskeolier som fx omega-3 fedtsyre og vitaminer som
						D-vitamin, jod og selen. TakeDaily sørger for, at du får det, du behøver – og så kan du fortsætte med at spise, som du gør nu.
						<br/><br/>
						Begynder du at spise mere fisk, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit TakeDaily</a>. Så
						er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.',
			'f' => '
					Din daglige kost indeholder ikke nok smør, margarine eller olie, som er vigtige kilder til A-vitamin og D-vitamin. Du har brug
					for begge vitaminer. Blandt andet for at styrke dit immunforsvar. TakeDaily sørger for, at du får det, du behøver – og så kan
					du fortsætte med at spise, som du gør nu.
					<br/><br/>
					Begynder du at spise mere fedtstof, skal du huske at ændre din profil på <a href="/account" target="_blank">Mit TakeDaily</a>.
					Så er du sikker på, at de mineraler og vitaminer vi sender til dig, indeholder lige præcis de doser, du har brug for.'
		],
		'none' => 'Du har en sund livsstil og passer godt på din krop. TakeDaily giver dig det mest basale, så din krop også får, hvad den har brug
							for de dage, hvor du slapper af og synder lidt.'
	],
	'combination_info'  => [
		'1'    => [
			'basic'          => 'Understøtter din generelle sundhed og hjælper til med at opretteholde kroppens naturlige balance',
			'basic-10-d'     => 'Bidrager til normal muskelfunktion<br/>Bidrager til vedligeholdelse af normale knogler<br/>Som supplement til din daglige kost med ekstra D-vitamin for stærke knogler og muskler',
			'basic-20-d'     => 'Bidrager til normal muskelfunktion<br/>Bidrager til vedligeholdelse af normale knogler<br/>Som supplement til din daglige kost med ekstra D-vitamin for stærke knogler og muskler'
		],
		'2'    => [
			'A' => 'Bidrager til moderens væv vækst under graviditeten<br/>Spiller en rolle i celledeling proces<br/>Støtter væksten af din baby',
			'B' => 'Bidrager til den normale funktion af immunsystemet<br/>Bidrager til at mindske træthed og udmattelse<br/>Bidrager til en god modstand og en følelse pasform',
			'C' => 'Bidrager til normal energi-givende metabolisme<br/>Bidrager til at mindske træthed og udmattelse<br/>For en fit og energisk følelse',
			'D' => 'Bidrager til den normale funktion af immunsystemet<br/>Bidrager til en god modstandsdygtighed',
			'E' => 'Bidrager til normal muskelfunktion<br/>Bidrager til vedligeholdelse af normale knogler<br/>For stærke knogler og muskler'
		],
		'3'    => [
			'a' => 'Bidrager til beskyttelse af celler mod oxidativt stress<br/>Bidrager til den normale funktion af immunsystemet<br/>Bidrager til at mindske træthed og udmattelse<br/>Bidrager til en god modstand og en følelse pasform',
			'b' => 'Bidrager til normal kognitiv funktion<br/>Bidrager til opretholdelse af normal hud<br/>For hjerner og sund hud',
			'c' => 'Nødvendige for vedligeholdelse af normale knogler<br/>For stærke knogler',
			'd' => 'Bidrager til normal energi-givende metabolisme<br/>Bidrager til at mindske træthed og udmattelse<br/>En fit og energisk følelse',
			'e' => 'Bidrager til normal funktion af hjertet<br/>NB! For at bære kravet oplysninger Be\'ve gives til forbrugeren, at den gavnlige effekt opnås ved et dagligt indtag på 250 mg EPA og DHA.<br/>For kardiovaskulære',
			'f' => 'Bidrager til beskyttelse af celler mod oxidativt stress<br/>Bidrager til vedligeholdelse af normale knogler<br/>Bidrager til opretholdelse af normal muskelfunktion<br/>Bidrager til opretholdelse af normal vision<br/>For stærke knogler og muskler'
		],
	],
	'call-me'           => [
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
	'datepicker'        => [
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