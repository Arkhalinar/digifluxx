$(document).ready(function() {

   // $('.rus').on('click', function() {
   //    var r = $('.localization').each(function() {
   //       var el = $(this);
   //       var key = (el.attr('caption'));
   //       el.text(rus[key]);
   //    });
   //    var date = new Date(new Date().getTime() + 6000 * 1000);
   //    document.cookie = "lang=russian; path=/; expires=" + date.toUTCString();
   //    document.getElementById('overlay').style.display='none';
   // });


   // $('.eng').on('click', function() {
   //    var r = $('.localization').each(function() {
   //       var el = $(this);
   //       var key = (el.attr('caption'));
   //       el.text(eng[key]);
   //    });
   //    var date = new Date(new Date().getTime() + 6000 * 1000);
   //    document.cookie = "lang=english; path=/; expires=" + date.toUTCString();
   //    document.getElementById('overlay').style.display='none';
   // });

   // $('.de').on('click', function() {
   //    var r = $('.localization').each(function() {
   //       var el = $(this);
   //       var key = (el.attr('caption'));
   //       el.text(de[key]);
   //    });
   //    var date = new Date(new Date().getTime() + 6000 * 1000);
   //    document.cookie = "lang=german; path=/; expires=" + date.toUTCString();
   //    document.getElementById('overlay').style.display='none';
   // });

   // $('.hu').on('click', function() {
   //    var r = $('.localization').each(function() {
   //       var el = $(this);
   //       var key = (el.attr('caption'));
   //       el.text(hu[key]);
   //    });
   //    var date = new Date(new Date().getTime() + 6000 * 1000);
   //    document.cookie = "lang=hungarian; path=/; expires=" + date.toUTCString();
   //    document.getElementById('overlay').style.display='none';
   // });

   var rus = {
      pheader: 'Начинаем работать через:',
      day: 'Дней',
      hour: 'Часов',
      min: 'Минут',
      sec: 'Секунд',
      pheader2: 'время народной криптоэкономики пришло!',
      pblock21:'Рынок криптовалют переполнен неадекватными предложениями. Ежедневно появляются криптовалютные проекты с сомнительными целями и задачами. Они обещают стремительный рост монет – необоснованный рост, так как в основу проекта не закладывается ничего, кроме финансовых фантазий и желаний разработчиков. Это подогревает рынок, привлекает все больше людей в сферу. ',
      pblock22:'Однако количество недовольных инвесторов, выбравших недобросовестный проект, неумолимо растет.',
      pblock23:'Трудности испытывают не только частные инвесторы и трейдеры. Действующие компании стремятся внедрить в свой сервис прием платежей в криптовалюте. На деле они сталкиваются со слабой технической архитектурой большинства криптовалют, что делает их невыгодными для использования.',
      pblock24:'Осознавая эти проблемы, мы сформировали сильное сообщество предпринимателей,',
      pblock25:'призванное создать по-настоящему ',
      pblock26:'народную криптовалюту – ',
      block2a:'Стать народным инвестором',
      pblock31:'выбор прогрессивных людей',
      pblock32:'Философия FOLK COIN',
      pblock33:'предельно проста:',
      pblock34:'криптовалюта обязана приносить выгоду не своим создателям,',
      pblock35:'а конечным пользователям – простым людям, компаниям и сервисам.',
      pblock36:'Нам не нужны просто сторонние инвесторы.',
      pblock37:'Мы ищем партнеров, готовых вложить частичку себя в развитие проекта',
      pblock372:'и получить от этого хорошую прибыль.',
      pblock38:'Если у Вас есть такое желание, ',
      pblock39:'FOLK COIN – это Ваш проект, присоединяйтесь!',
      pblock41:'Постоянная прибыль от роста курса',
      pblock42:'Команда разработчиков вместе с сообществом FOLK COIN использует эффективные методы популяризации и увеличения стоимости криптовалюты, что гарантирует прибыль каждому держателю монет',
      pblock43:'Уникальный спекулятивный инструмент',
      pblock44:'FOLK COIN позволит опытным и начинающим трейдерам вести выгодную торговлю криптовалютой на биржах',
      pblock45:'Анонимная криптовалюта для расчета',
      pblock46:'Децентрализованная сеть обеспечивает полную конфиденциальность транзакций и гарантирует работу с криптовалютой без вмешательства государственных органов и третьих лиц',
      pblock47:'Внедрение независимой народной монеты без центрального управления',
      pblock48:'Добавляйте в свой сервис оплату товаров и услуг криптовалютой',
      pblock49:'Простые и понятные технологические решения',
      pblock410:'Внедряйте FOLK COIN в систему приема платежей на своем сайте за счет простого подключения API и веб-кошельков',
      pblock411:'Надежная криптовалюта со стабильной динамикой роста',
      pblock412:'Принимайте оплату за товары и услуги в FOLK COIN, и будьте уверены в своей прибыли. Валюта будет расти в цене благодаря ее активной популяризации всеми членами сообщества',
      pblock413:'для людей',
      pblock414:'для компаний и онлайн-сервисов',
      pblock51:'Сильная техническая архитектура FOLK COIN также обеспечивает быстрые транзакции.',
      pblock52:'Надежное шифрование и современный софт гарантируют высокий уровень защиты криптовалюты от взлома и мошеннических действий.',
      pblock53:'Не теряйте свою прибыль – станьте одним из первых инвесторов Народной монеты!',
      pblock61:'Партнерская программа',
      pblock62:'Партнерская программа с выплатой до 60% от вложений Ваших рефералов – это реальность!',
      pblock63:'И эту реальность Вы создаете для себя, своих друзей и близких.',
      pblock64:'Расширяйте сообщество FOLK COIN, подключайте новых людей и получайте щедрое вознаграждение.',
      pblock65:'Народная монета – это наше общее дело и его успех принесет каждому участнику финансовую независимость.',
      block6a:'Хочу стать партнером',
      pblock71:'Время народной криптоэкономики пришло.',
      pblock72:'Не упускайте свой шанс',
      pblock73:'присоединяйтесь к сообществу успешных инвесторов',
      pblock74:'прямо сейчас!',
      pblock81:'Остались вопросы?',
      pblock82:'Мы всегда на связи.'
   };
   var eng = {
      pheader: 'Getting Started through:',
      day: 'DAYS',
      hour: 'HOURS',
      min: 'MINS',
      sec: 'SECS',
      pheader2: 'the time of peoples crypto economy has come!',
      pblock21:'Cryptocurrency market is overcrowded with inadequate offers. Cryptocurrency projects with doubtful goals and tasks appear every day. They promise rapid growth of the coin - groundless growth, as nothing constitutes the basis of the project, except for the financial fantasies and dreams of the developers. It heats the market, attracts more and more people to the sphere.',
      pblock22:'However the amount of dissatisfied investors, who have selected a shady project, grows implacably.',
      pblock23:'Difficulties are experienced not only by private investors and traders. The operating companies are trying to introduce into their service acceptance of the cryptocurrency payment. In fact, they face the weak technical architecture of most cryptocurrencies, which makes them unfit for use.',
      pblock24:'Realizing these problems, we formed a strong business community',
      pblock25:'designed to create a truly',
      pblock26: 'peoples cryptocurrency -',
      block2a:'Become peoples investor',
      pblock31:'choice of progressive people',
      pblock32:'The philosophy of FOLK COIN',
      pblock33:'is extremely simple:',
      pblock34:'cryptocurrency is obliged to bring benefits not to its creators,',
      pblock35:'but to end users – ordinary people, companies, and services.',
      pblock36:'We do not need third-party investors.',
      pblock37:'We look for partners ready to put a piece of themselves to the project development',
      pblock372:'and get a solid profit from it.',
      pblock38:'If you have such desire, ',
      pblock39:'FOLK COIN – is your project, join!',
      pblock41:'Constant profit from exchange rate growth',
      pblock42:'The development team, together with the FOLK COIN community, uses effective methods of popularizing and increasing the value of the cryptocurrency, which guarantees profit to each coin holder',
      pblock43:'Unique speculative tool',
      pblock44:'Positive dynamics of the FOLK COIN exchange rate will allow experienced and novice traders to conduct profitable trade of the cryptocurrency on the exchanges',
      pblock45:'Anonymous cryptocurrency for settlements',
      pblock46:'Decentralized network ensures complete confidentiality of transactions and guarantees the work with the crypto currency without the intervention of state bodies and third parties',
      pblock47:'Introduction of an independent peoples coin without central management',
      pblock48:'Add payment for goods and services with cryptocurrency to your service',
      pblock49:'Simple and clear technological decisions',
      pblock410:'Implement FOLK COIN into the payment acceptance system on your site by simply connecting the API and web wallets',
      pblock411:'Reliable cryptocurrency with stable growth dynamics',
      pblock412:'Accept payment for goods and services in FOLK COIN, and rest assured of your profit. The currency will grow in price due to its active promotion by all members of the community',
      pblock413:'for people',
      pblock414:'for companies and online services',
      pblock51:'The strong technical architecture of FOLK COIN provides fast transactions, as well.',
      pblock52:'Reliable encryption and modern software guarantee a high level of cryptocurrency protection from hacking and fraudulent activities.',
      pblock53:'Don’t loose your profit – become one of the first investors of the peoples coin!',
      pblock61:'Affiliate program',
      pblock62:'The partnership program with payment of up to 60% of the investments of your referrals is a reality!',
      pblock63:'And you create this reality for yourself, your friends and relatives.',
      pblock64:'Expand FOLK COIN community, attract new people and receive a munificent reward.',
      pblock65:'Peoples coin is our common cause ant its success will bring financial independence to each member.',
      block6a:'I want to become a partner',
      pblock71:'The time of peoples crypto economy has come.',
      pblock72:'Don’t loose your chance',
      pblock73:'join the community of successful',
      pblock74:'investors right now!',
      pblock81:'Still have questions?',
      pblock82:'We are always in touch.'
   };
   var de = {
      pheader: 'Tokenverkauf in:',
      day: 'DAYS',
      hour: 'HOURS',
      min: 'MINS',
      sec: 'SECS',
      pheader2: 'Die Zeit der volkskryptischen Ökonomie ist gekommen!',
      pblock21:'Der Markt der Kryptowährung ist voll von unangemessenen Angeboten. Jeden Tag gibt es Kryptowährungsprojekte mit zweifelhaften Zielen. Sie versprechen ein schnelles Wachstum der Münzen - ungerechtfertigtes Wachstum, da die Projekte auf nichts anderem als Finanzphantasien und Entwicklerwünschen basiert. Das wärmt den Markt auf, und lockt viele Menschen an. ',
      pblock22:'Die Anzahl der verärgerten Investoren die sich für ein unfaires Projekt entschieden haben wächst jedoch unaufhaltsam.',
      pblock23:'Schwierigkeiten haben nicht nur privaten Investoren und Trader. Viele Systembetreiber versuchen, die Zahlungsakzeptanz in Kryptowährung einzuführen. Tatsächlich stehen sie der schwachen technischen Architektur der meisten Kryptowährungen gegenüber, was sie unbrauchbar macht.',
      pblock24:'Um diese Probleme zu lösen, haben wir eine starke Gemeinschaft von System und Plattform Betreiber gebildet,',
      pblock25:'die eine Kryptowährung ',
      pblock26:'für das Volk schaffen wollen – ',
      block2a:'Werden Sie ein Volksinvestor',
      pblock31:'die Wahl der progressiven Menschen',
      pblock32:'Die Philosophie von FOLK COIN',
      pblock33:'ist sehr einfach:',
      pblock34:'Die Kryptowährung sollte Profit bringen, nicht ihren Erfindern,',
      pblock35:'sondern den Endnutzer - gewöhnliche Menschen, Firmen und Dienstleistern.',
      pblock36:'Wir brauchen keine externe Investoren.',
      pblock37:'Wir suchen Partner die bereit sind einen Teil von sich selbst in die Entwicklung des Projekts zu investieren,',
      pblock372:'und daraus einen guten Gewinn zu erzielen.',
      pblock38:'Wenn Sie solch einen Wunsch haben ',
      pblock39:'ist FOLK COIN – Ihr Projekt, machen Sie mit!',
      pblock41:'Konstante Gewinn von der Wachstumsrate',
      pblock42:'Das Entwicklungsteam verwendet zusammen mit der FOLK COIN-Community effektive Methoden, um den Wert der Kryptowährung zu popularisieren und zu erhöhen, was jedem Coinhalter Profit garantiert',
      pblock43:'Ein einzigartiges spekulatives Werkzeug',
      pblock44:'Die positive Dynamik des FOLK COIN — wird erfahrenen und unerfahrenen Tradern ermöglichen Profit an der Börse zu erzielen',
      pblock45:'Anonyme Kryptowährung beim bezahlen',
      pblock46:'Das dezentrale Netzwerk gewährleistet die vollständige Vertraulichkeit der Transaktionen und garantiert die Arbeit mit der Kryptowährung ohne das Eingreifen von staatlichen Stellen und Dritten',
      pblock47:'Die Einführung einer unabhängigen Volksmünze ohne zentrales Management',
      pblock48:'Fügen Sie Ihrer Service eine Zahlung für Waren und Dienstleistungen mit Kryptowährung hinzu',
      pblock49:'Einfache und klare technologische Lösungen',
      pblock410:'Implementieren Sie FOLK COIN im Zahlungssystem Ihrer Website, indem Sie einfach die API und Web-Wallet verbinden',
      pblock411:'Eine zuverlässige Kryptowährung mit stabiler Wachstumsdynamik',
      pblock412:'Akzeptieren Sie die Bezahlung für Waren und Dienstleistungen in FOLK COIN und seien Sie versichert von Ihrem Gewinn. Die Währung wird aufgrund ihrer aktiven Förderung durch alle Mitglieder der Gemeinschaft im Preis steigen',
      pblock413:'für Menschen',
      pblock414:'für Unternehmen und Online-Dienste',
      pblock51:'Die starke technische Architektur von FOLK COIN sorgt für schnelle Transaktionen.',
      pblock52:'Zuverlässige Verschlüsselung und moderne Software garantieren einen hohen Schutz der Kryptowährung vor Hackerangriffen und betrügerischen Aktivitäten.',
      pblock53:'Verlieren Sie nicht Ihr Profit - werde Sie einer der ersten Investoren der Volks Münze!',
      pblock61:'Partner-Programm',
      pblock62:'Das Partner-Programm mit der Zahlung von bis zu 60% der Investitionen Ihrer Empfehlungen ist eine Realität!',
      pblock63:'Und diese Realität schaffen Sie für sich selbst und Ihre Freunde und Bekannte.',
      pblock64:'Erweiteren Sie die FOLK COIN-Community, laden Sie neue Partner ein und erhalten dafür eine großzügige Belohnung.',
      pblock65:'Die Volks Münze ist unser gemeinsames Geschäft, und ihr Erfolg wird jedem Partner finanzielle Unabhängigkeit und Freiheit bringen.',
      block6a:'Ich möchte Partner werden',
      pblock71:'Die Zeit der Volkskryptoökonomie ist gekommen.',
      pblock72:'Verpassen Sie nicht Ihre Chance',
      pblock73:'schließen Sie sich jetzt der Community erfolgreicher Investoren',
      pblock74:'von FOLK COIN an!',
      pblock81:'Haben Sie noch Fragen?',
      pblock82:'Wir sind erreichbar.'
   };
   var hu = {
      pheader: 'Token értékesítés:',
      day: 'DAYS',
      hour: 'HOURS',
      min: 'MINS',
      sec: 'SECS',
      pheader2: 'A népek kripto gazdaságának ideje eljött!',
      pblock21:'A kriptovaluta piac tele van túlzó ajánlatokkal. Minden nap indulnak kriptovaluta projektek kétes célokkal. Megígérik az érmék gyors növekedését - alaptalan növekedést, mivel a projektek nem másra, csak pénzügyi fantáziákra és fejlesztői vágyakra alapulnak. Ez felhevíti a piacot és sok embert vonz.',
      pblock22:'Azonban a dühös befektetők száma, akik egy tisztességtelen projekt mellett döntöttek, feltartóztathatatlanul növekszik.',
      pblock23:'Nem csak a magánbefektetőknek és a kereskedőknek vannak nehézségei. Számos rendszerüzemeltető próbálja bevezetni a fizetés elfogadását kriptovalutában. Valójában szembe kell nézniük a legtöbb kriptovaluta gyenge technikai felépítésével, ami használhatatlanná teszi azokat.',
      pblock24:'Ezeknek a problémáknak a megoldásához, egy erős rendszer és platform felhasználói közösségét alakítottunk ki,',
      pblock25:'akik egy kriptovalutát ',
      pblock26:'akarnak létrehozni a nemzetek számára – ez a ',
      block2a:'Váljon befektetővé',
      pblock31:'a progresszív emberek választása',
      pblock32:'A FOLK COIN filozófiája',
      pblock33:'nagyon egyszerű:',
      pblock34:'a kripto valutának profitot kell hoznia, nemcsak feltalálói számára,',
      pblock35:'hanem a végfelhasználóknak is - hétköznapi embereknek, cégeknek és szolgáltatóknak.',
      pblock36:'Nincs szükségünk külső befektetőkre.',
      pblock37:'Olyan partnereket keresünk, akik hajlandóak részüket a projekt fejlesztésébe befektetni,',
      pblock372:'és abból jó hasznot húzni.',
      pblock38:'Ha ilyen vágya van, ',
      pblock39:'a FOLK COIN az Ön projektje, csatlakozzon hozzánk!',
      pblock41:'Állandó nyereség a növekedési rátából',
      pblock42:'A fejlesztőcsapat és a FOLK COIN közösség együtt hatékony módszereket használ fel a kriptovaluta népszerűsítésére és értékének növelésére, ezáltal biztosítva a nyereséget minden érmetulajdonos számára',
      pblock43:'Egyedülálló spekulatív eszköz',
      pblock44:'A FOLK COIN pozitív dinamikája - lehetővé teszi a tapasztalt és tapasztalatlan kereskedők számára, hogy nyereséget érjenek el a tőzsdén',
      pblock45:'Anonim kriptovaluta fizetéskor',
      pblock46:'A decentralizált hálózat biztosítja a tranzakciók teljes titoktartását és garantálja a kriptovalutákkal való munkát a kormányzati szervek és harmadik fél beavatkozása nélkül',
      pblock47:'Egy független népek érméjének bevezetése központi irányítás nélkül',
      pblock48:'Csatoljon hozzá árui és szolgáltatásai értékesítéséhez egy kriptovaluta fizetést',
      pblock49:'Egyszerű és világos technológiai megoldások',
      pblock410:'Helyezze be a FOLK COIN alkalmazását a webhelyének fizetési rendszerébe, az API és a web-pénztárca egyszerű összekapcsolásával',
      pblock411:'Egy megbízható kriptovaluta stabil növekedési lendülettel',
      pblock412:'Fogadja el az árucikkek és szolgáltatások kifizetését FOLK COIN-ban és biztosítva lesz a nyeresége. A valuta ára emelkedni fog a közösség tagjainak aktív támogatása által',
      pblock413:'az embereknek',
      pblock414:'vállalkozások és online szolgáltatások számára',
      pblock51:'A FOLK COIN erős technikai felépítése biztosítja a gyors tranzakciókat.',
      pblock52:'A megbízható titkosítást és a korszerű szoftverek garantálják a kriptovaluta magas szintű védelmét hacker támadásokkal és csalárd tevékenységekkel szemben.',
      pblock53:'Ne veszítse el nyereségét – legyen egyik első befektetője a népek érméjének!',
      pblock61:'Partner program',
      pblock62:'A partner program kifizetése legfeljebb 60%-a az ajánlottjai befektetésének, ez egy realitás!',
      pblock63:'És ezt a valóságot létrehozhatja magának, barátainak és ismerőseinek.',
      pblock64:'Terjessze a FOLK COIN közösséget, hívjon meg új partnereket és kapjon érte nagyvonalú jutalmat.',
      pblock65:'A népek érméje közös vállalkozásunk és sikere pénzügyi függetlenséget és szabadságot hoz minden partner számára.',
      block6a:'Szeretnék partner lenni',
      pblock71:'Eljött a népek kripto gazdaságának ideje.',
      pblock72:'Ne hagyja ki az esélyét',
      pblock73:'csatlakozzon most a FOLK COIN sikeres',
      pblock74:'befektetőinek közösségéhez!',
      pblock81:'Kérdése van?',
      pblock82:'Elérhetőek vagyunk.'
   };

});
