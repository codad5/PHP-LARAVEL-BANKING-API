<?php
namespace App\Traits;
use App\Models\Account;
use App\Models\transaction;

/**
 * This trait contains all the methods that are used to perform transactions
 * Class Transactions
 * @package App\Traits
 */
trait Transactions{

    /**
     * @param Account $account
     * @param integer $amount
     * @param string $type - if type is debit, amount is subtracted from account balance, if type is credit, amount is added to account balance
     * @param integer $old_balance
     * @param string|null $description
     */
    public function addTransaction($account, $amount, $type, $old_balance, $description = null){
        return transaction::create([
            "account_id" => $account->id,
            "transaction_type" => $type,
            "transaction_reference" => $this->generateTransactionReference(),
            "account_number" => $account->account_number,
            "amount" => $amount,
            "narration" => $description,
            "new_balance" => $account->account_balance,
            "old_balance" => $old_balance,
            "status" => "success"
        ]);
    }

    /**
     * This to get all transactions of an account
     * @param Account $account
     */
    public function getTransactions($account){
        return transaction::where("account_id", $account->id)->get();
    }

    /**
     * This method is used to generate a unique transaction reference with the format "TRF-<random number>"
     * @return string
     */
    protected function generateTransactionReference(){
        $uuid = uniqid();
        $uuid = preg_replace('/[^A-Za-z0-9\-]/', '', $uuid);
        return "TRX_".$uuid;
    }

    /**
     * This method is used to transfer money from one account to another
     * @param Account $from_account
     * @param Account $to_account
     * @param integer $amount
     */
    protected function makeTransfer(Account $from_account, Account $to_account, $amount){
        $old_balance = $from_account->account_balance;
        $from_account->account_balance -= $amount;
        $from_account->save();
        $this->addTransaction($from_account, $amount, "debit", $old_balance, "transfer to $to_account->account_number ($to_account->name)");
        $old_balance = $to_account->account_balance;
        $to_account->account_balance += $amount;
        $to_account->save();
        return $this->addTransaction($to_account, $amount, "Credit", $to_account->account_balance, "transfer from $from_account->account_number ($from_account->name)");
    }
    
}