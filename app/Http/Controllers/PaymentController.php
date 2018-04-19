<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\UserSetting;
use App\Models\NotifyAccess;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function post(Request $request) {
        $payment = Payment::find($request->input('WMI_PAYMENT_NO'));

        if ($payment == null) {
            return response('WMI_RESULT=RETRY&WMI_DESCRIPTION=' . urlencode('Номер заказа не найден. Обратитесь в техподдержку'));
        }

        $balance = UserSetting::where('user_id', '=', $payment->source_id)
            ->where('name', '=', 'balance')
            ->first();

        $sum = ($request->input('WMI_PAYMENT_AMOUNT') - $request->input('WMI_COMMISSION_AMOUNT')) * 100;

        $balance->value += $sum;
        $balance->save();

        $notify = new NotifyAccess;

        $notify->source_id = $payment->source_id;
        $notify->user_id = $payment->user_id;
        $notify->status = NotifyAccess::ACTIVE_STATUS;
        $notify->access_type = $payment->forever ? NotifyAccess::PERMANENT_ACCESS : NotifyAccess::LIMITED_ACCESS;
        $notify->end_at = $payment->forever ? null : Carbon::now()->addDays($payment->days);
        $notify->save();

        return response('WMI_RESULT=RETRY&WMI_DESCRIPTION=' . urlencode('Sum: ' . $sum));
    }
}
