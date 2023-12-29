<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('imports_cash')->nullable();
            $table->double('imports_network')->nullable();
            $table->double('imports_bank_transfer')->nullable();
            $table->double('card_details_hand_labour')->nullable();
            $table->double('card_details_new_parts')->nullable();
            $table->double('card_details_used_parts')->nullable();
            $table->double('card_details_tax')->nullable();
            $table->double('expenses_cash')->nullable();
            $table->double('expenses_network')->nullable();
            $table->double('custody_administration_cash')->nullable();
            $table->double('custody_administration_network')->nullable();
            $table->double('cash_to_administration')->nullable();
            $table->double('advances_and_salaries_cash')->nullable();
            $table->double('advances_and_salaries_network')->nullable();
            $table->longText('notes')->nullable();
            $table->bigInteger('sale_order_id')->unsigned()->nullable();
            $table->bigInteger('client_payment_id')->unsigned()->nullable();
            $table->bigInteger('client_collecting_id')->unsigned()->nullable();
            $table->bigInteger('expenses_id')->unsigned()->nullable();
            $table->bigInteger('purchase_order_id')->unsigned()->nullable();
            $table->bigInteger('supplier_payment_id')->unsigned()->nullable();
            $table->bigInteger('supplier_collecting_id')->unsigned()->nullable();
            $table->bigInteger('sale_order_return_id')->unsigned()->nullable();
            $table->bigInteger('purchase_order_return_id')->unsigned()->nullable();
//            $table->bigInteger('salary_id')->unsigned()->nullable();
            $table->bigInteger('advance_id')->unsigned()->nullable();
//            $table->bigInteger('scheduled_advance_id')->unsigned()->nullable();
            $table->bigInteger('reward_id')->unsigned()->nullable();
//            $table->bigInteger('vacation_id')->unsigned()->nullable();
            $table->bigInteger('discount_id')->unsigned()->nullable();
            $table->bigInteger('employee_salary_log_id')->unsigned()->nullable();
            $table->bigInteger('money_safe_id')->unsigned()->nullable();
            $table->bigInteger('bank_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statements');
    }
}
