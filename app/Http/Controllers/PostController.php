<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use Validator;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Tip;
use App\Models\PostSubscription;

class PostController extends Controller
{
    //  ユーザーを含めた投稿情報を取得
    public function index(Request $request)
    {   
        $items = Post::with('user')->get();
        return view('posts.home', compact('items'));
    }
//     投稿製作画面表示
    public function create(Request $request)
    {
        return view('posts.create');
    }
//     Postインスタンス作成＆DBに保存
    public function store(ArticleRequest $request)
    {
        Post::create(
            array(
              'user_id' => Auth::id(),
              'title' => $request->title,
              'content' => $request->content,
              'is_fee' => $request->is_fee,
              'price' => $request->price,
              'category_code' => $request->category

            )
          );
          return redirect('/');
    }
//  ユーザーを含めた投稿情報を取得
    public function show($id){
      $post = Post::with('user')->findorFail($id);
      return view('posts.show', compact('post'));
    }
//     投稿情報をカテゴリーでフィルターする
    public function filter_categories($category_id){
      $items =  Post::where('category_code', $category_id)->get();
      return view('posts.home', compact('items'));
    }
//  投稿情報をいいね順に並べる
    public function popular_posts(Request $request){
      $items = Post::withCount('likes')
      ->orderBy('likes_count', 'desc')
      ->paginate();
      return view('posts.home', compact('items'));
    }
//  編集画面表示
    public function edit($id){
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }
//     $requestが存在するかひとつずつ確認して内容を更新
    public function update(Request $request, $id){
        $post = Post::find($id);
        $title = $request->title;
        $content = $request->content;
        $price = $request->price;
        $category = $request->category;
          if($title){
            $post->title = $request->title;
               }
         if($content){
             $post->content = $request->content;
             }
        $post->is_fee = $request->is_fee;
              if($price){
            $post->price = $request->price;
        }

        if($category){
            $post->category_code = $request->category;
        }
        $post->update();
        return redirect('/');
    }
//     投稿情報を取得して削除
    public function destroy($id){
        $item = Post::find($id);
        $item->delete();
        $id = Auth::id();
       return redirect(route('user.show', ['id' => $id,]));
//         return redirect('/');
    }
//     Likeインスタンス作成＆Like中間テーブルに値を入れる
    public function switchLike($id){
          Like::create(
            array(
              'user_id' => Auth::id(),
              'post_id' => $id
            )
          );
          return redirect()->back();
    }
//     Like情報を取得して削除
    public function switchUnlike($id){
      $like = Like::where('post_id', $id)->where('user_id', Auth::id())->first();
      $like->delete();
         return redirect()->back();
    }
//     コメントの中身のバリデーション
// Commentインスタンス作成＆中間テーブルに値を入れる
    public function storeComment(Request $request, $id){
        $rules = [
        'content' =>'required',
        ];
        $messages = [
            'content.required' => 'コメントの本文をご記入ください。',
            ];
        $validator = Validator::make($request->all(), $rules, $messages);
         if($validator->fails()){
             return redirect(route('post.show', ['id' => $id,]))
               ->withErrors($validator)
                ->withInput();
         }
      Comment::create(
        array(
          'user_id' => Auth::id(),
          'post_id' => $id,
          'content' => $request->content,
        )
      );
      return redirect(route('post.show', ['id' => $id,]));
    }
//     有料記事お支払いページに飛ぶ
    public function getPaymentPage(Request $request, $id){
      $post = Post::with('user')->findorFail($id);
      $user = Auth::user();
      return view('posts.payment.index', compact('post', 'user'));
  
  }
//     チップお支払いページに飛ぶ
  public function getTipPayment(Request $request, $id){
      $post = Post::with('user')->findorFail($id);
      $user = Auth::user();
      return view('posts.payment.tip', compact('post', 'user'));

  }
    public function donePayment(Request $request, $id){
//         StripeAPIキーを取得して決済を作成
      $post = Post::find($id);
    \Stripe\Stripe::setApiKey(\Config::get('payment.stripe_secret_key'));

        try {
            $user = User::find(Auth::id());
            $chargeOject = [
                'amount'      => $request->price,
                'currency'    => 'jpy',
                'description' => 'ユーザー：'.$user->name."=>".$post->title."投稿購読分",
                'customer'      => $user->stripe_code,
            ];

            $charge = \Stripe\Charge::create($chargeOject);
//             投稿決済インスタンス作成&投稿決済中間テーブルにデータを保存
            PostSubscription::create(
              array(
                'user_id' => Auth::id(),
                'post_id' => $id,
              )
            );
        } catch (\Stripe\Exception\CardException $e) {
            $body = $e->getJsonBody();
            $errors  = $body['error'];

            return redirect(route('post.show', ['id' => $id,]))->with('errors', "決済に失敗しました。しばらく経ってから再度お試しください。");
        }


        return redirect(route('post.show', ['id' => $id,]))->with('success', "購読が完了しました。");
  }

  public function doneTipPayment(Request $request, $id){
//       値段フォームバリデーション
        $rules = [
        'price' =>'required',
        'price' => 'integer',
        ];
        $messages = [
            'price.required' => '値段をご記入ください。',
            'price.integer' => '整数値でご記入ください。',
            ];
        $validator = Validator::make($request->all(), $rules, $messages);
         if($validator->fails()){
             return redirect(route('payment.tip', ['id' => $id,]))
               ->withErrors($validator)
                ->withInput();
         }
//       投稿を取得してチップ決済を作成
    $post = Post::find($id);
    \Stripe\Stripe::setApiKey(\Config::get('payment.stripe_secret_key'));
    try {
      $user = User::find(Auth::id());
    $chargeOject = [
      'amount'      => $request->price,
      'currency'    => 'jpy',
      'description' => 'ユーザー：'.$user->name."=>".$post->title."、チップ支払い分",
      'customer'      => $user->stripe_code,
  ];
  $charge = \Stripe\Charge::create($chargeOject);
//    チップインスタンス作成&チップ中間テーブルにデータ保存
  Tip::create(
    array(
      'user_id' => Auth::id(),
      'post_id' => $id,
      'comment' => $request->comment,
      'price' => $request->price,
    )
  );
} catch (\Stripe\Exception\CardException $e) {
  $body = $e->getJsonBody();
  $errors  = $body['error'];

  return redirect(route('post.show', ['id' => $id,]))->with('errors', "決済に失敗しました。しばらく経ってから再度お試しください。");
}


return redirect(route('post.show', ['id' => $id,]))->with('success', "お支払いが完了しました。");
  }
}
