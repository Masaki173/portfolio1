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
    public function index(Request $request)
    {   
        $items = Post::with('user')->get();
        return view('posts.home', compact('items'));
    }
    public function create(Request $request)
    {
        return view('posts.create');
    }
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
    public function show($id){
      $post = Post::with('user')->findorFail($id);
      $tips = Tip::with('user')->get();
      $comments = Comment::with('user')->get();
     
      return view('posts.show', compact('post', 'comments' , 'tips'));
    }
    public function filter_categories($category_id){
      $items =  Post::where('category_code', $category_id)->get();
      return view('posts.home', compact('items'));
    }
    public function popular_posts(Request $request){
      $items = Post::withCount('likes')
      ->orderBy('likes_count', 'desc')
      ->paginate();
      return view('posts.home', compact('items'));
    }
    public function edit($id){
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }
    public function update(PostRequest $request, $id){
        $post = Post::find($id);
        $form = $request->all();
        unset($form['_token']);
        $post->fill($form)->save();
        return redirect('/');
    }
    public function destroy($id){
        $item = Post::find($id);
        $item->delete();
        return redirect('/');
    }
    public function switchLike($id){
          Like::create(
            array(
              'user_id' => Auth::id(),
              'post_id' => $id
            )
          );
          return redirect()->back();
    }
    public function switchUnlike($id){
      $like = Like::where('post_id', $id)->where('user_id', Auth::id())->first();
      $like->delete();
         return redirect()->back();
    }
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
    public function getPaymentPage(Request $request, $id){
      $post = Post::with('user')->findorFail($id);
      $user = Auth::user();
      return view('posts.payment.index', compact('post', 'user'));
  
  }
  public function getTipPayment(Request $request, $id){
      $post = Post::with('user')->findorFail($id);
      $user = Auth::user();
      return view('posts.payment.tip', compact('post', 'user'));

  }
    public function donePayment(Request $request, $id){
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
            PostSubscription::create(
              array(
                'user_id' => Auth::id(),
                'post_id' => $id,
              )
            );
        } catch (\Stripe\Exception\CardException $e) {
            $body = $e->getJsonBody();
            $errors  = $body['error'];

            return redirect('/')->with('errors', "決済に失敗しました。しばらく経ってから再度お試しください。");
        }


        return redirect('/')->with('success', "購読が完了しました。");
  }

  public function doneTipPayment(Request $request, $id){
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

  return redirect('/')->with('errors', "決済に失敗しました。しばらく経ってから再度お試しください。");
}


return redirect(route('post.show', ['id' => $id,]))->with('success', "お支払いが完了しました。");
  }
}
