<style type="text/css">
	small{
		color: darkred;
		font-size: 16px;
	}
</style>

<h1>Welcome to Aqar Review website Documentation</h1>
<h3>System Technology</h3>
<ul>
	<li>Laravel : 5.8</li>
	<li>Carbon Backage : 2.29</li>
	<li>Migration files with Forign keys (Run first time before start)</li>
	<li>Seeder data for Tests and default data (Run first time before start)</li>
	<li>Generate Admin Auto at first Start - You can update after that</li>
</ul>
<hr>
<h3>System Requirements</h3>
<ul>
	<li>Apache (PHP) Server >=7.1.3</li>
	<li>MySQL Server >=5.0</li>
	<li>Processor: core I3-4160 or higher</li>
	<li>Memoury >= 1GB</li>
	<li>HDD/SSD Memoury >= 130 MB</li>
</ul>
<hr>
<h3>How to Install (locally)</h3>
<ul>
	<li>using this command to download project from githup git clone <small>https://github.com/dabour25/aqarreview.git</small></li>
	<li>go to database inside server or localhost then create new database</li>
	<li>if .env not found inside project folder use <small>composer install</small></li>
	<li>go to .env file inside project folder</li>
	<li>update database connection data with your database data</li>
	<li>After Download open power shell or cmd (right click inside project folder then select power shell)</li>
	<li>type this command <small>php artisan migrate</small></li>
	<li>type this command <small>php artisan db:seed</small></li>
	<li>type this command <small>php artisan serve</small></li>
	<li>go to in your browser to this link <small>http://127.0.0.1:8000</small></li>
</ul>
<hr>
<h3>How to Install (server cp)</h3>
<ul>
	<li>using this command to download project from githup git clone <small>https://github.com/dabour25/aqarreview.git</small></li>
	<li>go to database inside server then create new database</li>
	<li>if .env not found inside project folder use <small>composer install</small></li>
	<li>go to .env file inside project folder</li>
	<li>update database connection data with your database data</li>
	<li>After Download open power shell or cmd (right click inside project folder then select power shell)</li>
	<li>type this command <small>php artisan migrate</small></li>
	<li>type this command <small>php artisan db:seed</small></li>
	<li>get all files/folders inside <small>/aqar</small> (Create aqar folder first)</li>
	<li>get all files/folder witch inside <small>/aqar/public</small> to <small>/</small> or public_html in server</li>
	<li>open index.php then change <small>require __DIR__.'/../vendor/autoload.php';</small> to new directory in server</li>
	<li>change <small>$app = require_once __DIR__.'/../bootstrap/app.php';</small> to new directory in server</li>
</ul>
