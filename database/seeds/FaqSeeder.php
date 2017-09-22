<?php

use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$repo = new \App\Apricot\Repositories\FaqRepository;

		$repo->create( 'Hvordan fungerer TakeDaily?', 'Det er simpelt. Tag vores sunhedstest online, hvor vi stiller dig nogle simple spørgsmål. Det tager cirka 2-3 minutter. Vi skræddersyer din TakeDaily og sender den til dig hver 28 dag og som passer i din postkasse. Ved du præcist hvad du skal have, så kan du selv vælge blandt vores produkter og sammensætte din egen TakeDaily. Har du brug for rådgivning, så ringer en af vores specialister dig gerne op og gennemgår processen med dig. Og nej, der er ingen binding, du kan opsige når som helst.', [
			[
				'locale'   => 'en',
				'question' => 'How does TakeDaily work?',
				'answer'   => '...'
			]
		] );

		$repo->create( 'Hvor lang tid skal jeg tage TakeDaily?', 'For at opnå bedste effekt skal du tage TakeDaily minimum 3-6 måneder. Men som udgangspunkt skal du tage dine vitaminpiller hver dag fremadrettet. Såfremt din livstil ændrer sig, kan du ændre dette i dine egne indstillinger, så du altid får præcist det du har brug for. Bliver du ældre sørger TakeDaily selv for at ændre indholdet af dine vitaminer og mineraler, således at det passer præcist til hvor du er i livet. Det er smart ikke? :-)');

		$repo->create( 'Jeg har allergi. Kan jeg bruge TakeDaily?', 'Dette afhænger af hvilken allergi du har. Skriv til os på support@takedaily.com så skræddersyer vi en TakeDaily der passer til dig afhængig af hvilken allergi du har.');

		$repo->create( 'Jeg er vegetar/veganer. Kan jeg bruge TakeDaily?', 'Ja, TakeDaily er perfekt såfremt du er vegetar eller veganer. Svar på spørgsmålene i testen, så sørger vi for en skræddersyet TakeDaily til dig, hvor du får alt det du har brug for. Du kan også vælge en af vores predefinerede pakker.');

		$repo->create( 'Jeg er gravid, kan jeg bruge TakeDaily?', 'Ja naturligvis. Svar på spørgsmålene i vores test og så sammensætter vi en skræddersyet TakeDaily til dig. Du bør dog altid tage kontakt til din læge, inden du benytter din TakeDaily.');

		$repo->create( 'Er TakeDaily godkendt til Halal eller kosher?', 'Ja TakeDaily er godkendt til Halal og kosher.');

		$repo->create( 'Kan jeg afmelde mig TakeDaily?', 'Ja, altid. Vi ser selvfølgelig gerne at du forbliver kunde hos os, så er der noget vi kan gøre bedre, så skriv til os på support@takedaily.com. Ønsker du alligevel at afmelde dig, kan du gøre dette under afsnittet ”Mit TakeDaily”. Husk du også kan udskyde din levering af din TakeDaily, således at det passer med at du ikke har mere tilbage.');
	}
}
