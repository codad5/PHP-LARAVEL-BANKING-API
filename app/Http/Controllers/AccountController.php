<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Traits\{HttpResponses, Transactions};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Nette\Utils\Random;

class AccountController extends Controller
{
    use HttpResponses, Transactions;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a new account of a user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            "name" => ['required', 'string', 'max:50'],
            "password" => ['required', 'confirmed', Password::defaults()],
            "account_type" => ['required', 'string', 'in:savings,current'],
        ]);
        //  check if any user is logged in
        if (!Auth::check()) {
           return $this->error([
                "message" => "You are not logged in"
              ], "You are not logged in", 401);
        }
        // generate a unique account number that does nit exist in the database
        $account_number = Random::generate(10, "0-9");
        while (Account::where("account_number", $account_number)->exists()) {
            $account_number = Random::generate(10, "0-9");
        }
        $newAccount = Account::create([
            'name' => $request->name,
            "password" => Hash::make($request->password),
            "account_type" => $request->account_type,
            "account_number" => $account_number,
            "account_balance" => 10000,
            "account_status" => "active",
            "user_id" => Auth::user()->id
        ]);
        $newAccount->password = null;
        return $this->success([
            "message" => "Account created successfully",
            "data" => $newAccount
        ]);
          
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Deposit money into an account
     * @param Request $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function transfer(Request $request)
    {
        $this->validate($request, [
            "from" => ['required', 'max:50'],
            "to" => ['required', 'max:50'],
            "amount" => ['required', 'numeric', 'min:50', 'max:100000'],
            "password" => ['required', 'string', 'min:8']
        ]);
        
        
        try{

        // get account details
        $account = $this->validateAccountUserAccess($request->from, $request->password);
        $recipient = $this->validateAccountUserAccess($request->to, null, false);
        // update the account balance
        $old_balance = $account->account_balance;
        $this->makeTransfer($account, $recipient, $request->amount);
        return $this->success([
                "old_balance" => $old_balance,
                "new_balance" => $account->account_balance,
                "recipient" => $recipient->name,
                "recipient_account" => $recipient->account_number,

            ], "Transfer successful");
        }catch(\Exception $e){
            return $this->error([
                "message" => $e->getMessage()
            ], $e->getMessage(), 500);
        }
        

        
    }
    /**
     * Check balance of an account
     * @param Request $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function balance(Request $request)
    {

        $this->validate($request, [
            "account_number" => ['required', 'max:50'],
            "password" => ['required', 'string', 'min:8']
        ]);
        // get account details
        try{
            $account = $this->validateAccountUserAccess($request->account_number, $request->password);
                return $this->success([
                    "message" => "Balance retrieved successfully",
                    "data" => $account->account_balance
                ]);
        }catch(\Exception $e){
            return $this->error([
                "message" => $e->getMessage()
            ], $e->getMessage(), 500);
        }
    }
    /**
     * Get alll transactions of an account
     * @param Request $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function transactions(Request $request)
    {
        $this->validate($request, [
            "account_number" => ['required', 'max:50'],
            "password" => ['required', 'string', 'min:8']
        ]);
        // get account details
        try{
            $account = $this->validateAccountUserAccess($request->account_number, $request->password);
            $transactions = $this->getTransactions($account);
            return $this->success($transactions);
        } catch(\Exception $e){
            return $this->error([
                "message" => $e->getMessage()
            ], $e->getMessage(), 500);
        }
    }
    /**
     * Validate account number , password and active status
     * @param string|integer $account
     * @param string $password
     * @param boolean $use_auth
     * @param boolean $check_status
     * @throws \Exception
     * @return Account
     */
    protected function validateAccountUserAccess($account_number, $password, $use_auth = true, $check_status = true)
    {   
        // get account details
        $account = Account::where("account_number", $account_number)->first();
        if (!$account) {
            throw new \Exception("Account does not exist");
        }
        // check if the account is active
        if ($account->account_status != "active" && $check_status) {
            throw new \Exception("Account is not active");
        }
        //check if the current user is the owner of the account
        if (Auth::user()->id != $account->user_id && $use_auth) {
            throw new \Exception("You do not have access to this account");
        }
        //check password
        if (!Hash::check($password, $account->password)  && $use_auth) {
            throw new \Exception("Invalid password");
        }
        return $account;
    }
}
