<?php namespace {

    use FrenchFrogs\Laravel\Database\Schema\Blueprint;
    use FrenchFrogs\Laravel\Support\Facades\Schema;
    use Illuminate\Database\Migrations\Migration;

    /**
     * @source 1
     */
    class ModifyUrlLengthDeDcMw extends Migration
    {
        /**
         * Enables, if supported, wrapping the migration within a transaction.
         *
         * @var bool
         */
        public $withinTransaction;
        /**
         * The name of the database connection to use.
         *
         * @var string
         */
        protected $connection = null;

        public function up()
        {
            Schema::table("downloads", function (Blueprint $table) {
                $table->text('url')->change();
            });
        }


        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            //
        }
    }
}
