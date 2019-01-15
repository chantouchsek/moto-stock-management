<?php

namespace App\Observers;

use App\Models\Loan;
use App\Models\User;
use App\Notifications\LoanRequested;

class LoanRequestObserver
{
    /**
     * Listen to the User created event.
     *
     * @param Loan $loan
     * @return void
     */
    public function updated(Loan $loan)
    {
        $users = User::role(['Supper Admin', 'Admin'])->get();
        foreach ($users as $user) {
            if ($loan->staff->id !== $user->id) {
                $user->notify(new LoanRequested($loan));
            }
        }
    }
}
