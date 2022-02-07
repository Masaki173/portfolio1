<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Payment extends Model
{
    //       DBに保存するStripeデータを指定
  public static function setCustomer($token, $user)
  {
      \Stripe\Stripe::setApiKey(\Config::get('payment.stripe_secret_key'));

      //Stripe上に顧客情報をtokenを使用することで保存
      try {
          $customer = \Stripe\Customer::create([
              'card' => $token,
              'name' => $user->name,
              'description' => $user->id
          ]);
        //   dump($customer);
        //   exit;
      } catch(\Stripe\Exception\CardException $e) {
          /*
           * カード登録失敗時には現段階では一律で別の登録カードを入れていただくように
           * 促すメッセージで統一。
           * カードエラーの類としては以下があるとのこと
           * １、カードが決済に失敗しました
           * ２、セキュリティーコードが間違っています
           * ３、有効期限が間違っています
           * ４、処理中にエラーが発生しました
           *  */
          return false;
      }

      $targetCustomer = null;
      if (isset($customer->id)) {
          $targetCustomer = User::find(Auth::id());//要するに当該顧客のデータをUserテーブルから引っ張りたい
          $targetCustomer->stripe_code = $customer->id;
          $targetCustomer->update();
          return true;
      }
      return false;
  }
  public static function updateCustomer($token, $user)
    {
        \Stripe\Stripe::setApiKey(\Config::get('payment.stripe_secret_key'));

        try {
            $customer = \Stripe\Customer::retrieve($user->stripe_code);
            $card = $customer->sources->create(['source' => $token]);

            if (isset($customer)) {
                $customer->default_source = $card["id"];
                $customer->save();
                return true;
            }

        } catch(\Stripe\Exception\CardException $e) {
            /*
             * カード登録失敗時には現段階では一律で別の登録カードを入れていただくように
             * 促すメッセージで統一。（メッセージ自体はController側で制御しています）
             * カードエラーの類としては
             * １、カードが決済に失敗しました
             * ２、セキュリティーコードが間違っています
             * ３、有効期限が間違っています
             * ４、処理中にエラーが発生しました
             *  */
            return false;
        }
        return true;
    }
}
