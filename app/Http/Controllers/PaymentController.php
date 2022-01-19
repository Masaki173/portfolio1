<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Payment;
// require_once('../../vendor/autoload.php');
class PaymentController extends Controller
{
    // public function getCurrentPayment(Request $request, $id){
    //    $user = Auth::user();
    //     $post = Post::find($id);
    //     $defaultCard = Payment::getDefaultcard($user);

    //     return view('user.payment.index', compact('user', 'defaultCard'));

    // }

    public function getPaymentForm(Request $request){
        $user = Auth::user();
        // $post = Post::find($id);
        return view('posts.payment.form', compact('user'));

    }


    public function storePaymentInfo(Request $request){
     
        $token = $request->stripeToken;
        $user = Auth::user(); //要するにUser情報を取得したい
        $ret = null;
        
        if ($token) {
            if (!$user->stripe_code) {
                $result = Payment::setCustomer($token, $user);

                /* card error */
                if(!$result){
                    $errors = "カード登録に失敗しました。入力いただいた内容に相違がないかを確認いただき、問題ない場合は別のカードで登録を行ってみてください。";
                    return redirect('/payment/form')->with('errors', $errors);
                }
            

       
            } else {
                $defaultCard = Payment::getDefaultcard($user);
                if (isset($defaultCard['id'])) {
                   Payment::deleteCard($user);
                }

                $result = Payment::updateCustomer($token, $user);

                /* card error */
                if(!$result){
                    $errors = "カード登録に失敗しました。入力いただいた内容に相違がないかを確認いただき、問題ない場合は別のカードで登録を行ってみてください。";
                    return redirect('/payment/form')->with('errors', $errors);
                }

            }
        } else {
            return redirect('/payment/form')->with('errors', '申し訳ありません、通信状況の良い場所で再度ご登録をしていただくか、しばらく立ってから再度登録を行ってみてください。');
        }


        return redirect('/')->with("success", "カード情報の登録が完了しました。");
    }


    public function deletePaymentInfo(){
        $user = User::find(Auth::id());

        $result = Payment::deleteCard($user);

        if($result){
            return redirect('/payment')->with('success', 'カード情報の削除が完了しました。');
        }else{
            return redirect('/payment')->with('errors', 'カード情報の削除に失敗しました。恐れ入りますが、通信状況の良い場所で再度お試しいただくか、しばらく経ってから再度お試しください。');
        }
    }
}
