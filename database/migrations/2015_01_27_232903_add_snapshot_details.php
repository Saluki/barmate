<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSnapshotDetails extends Migration {

	public function up()
	{
		Schema::table('cash_snapshots', function(Blueprint $table)
		{
			$table->boolean('is_closed')->default(false);

			$table->decimal('predicted_amount',6,2)->nullable()->after('sum');

			$table->renameColumn('sum','amount');
		});
	}

	public function down()
	{
		Schema::table('cash_snapshots', function(Blueprint $table)
		{
			$table->renameColumn('amount','sum');

			$table->dropColumn(['is_closed','predicted_amount']);
		});
	}

}
