<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostsController extends Controller
{
    private $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->index());
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $gouv=$request->gouvernorat;
        $deleg=$request->delegation;

        $id = DB::table('delegations')
            ->join('gouvernorats', 'delegations.gouvernorat_id', 'gouvernorats.id')
            ->where([
                ['gouvernorats.name', '=', $gouv],
                ['delegations.name', '=', $deleg]
            ])
            ->select('delegations.id')
            ->get();

        $post_data = $request->all();
        // echo "avant modification = " . $post_data["urlToImage"];
        $toStore = base64_decode( $post_data["urlToImage"]);
        $name = date('YmdHis');
        // echo "aprés modification = " . $post_data["urlToImage"];
        file_put_contents("images/$name.jpg",$toStore);
        $post_data["urlToImage"] = "images/$name.jpg" ;
        $report = Post::create([
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'type' => $request->type,
            'urlToImage' => $post_data["urlToImage"],
            'time' => $request->time,
            'description' => $request->description,
            'delegation_id' => $id->first()->id,
    ]);

        $report->save();
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

    public function showall()
    {
        $posts=DB::table("posts")->where('type' , 'like' , '%'.'%')->paginate(10);
        $data = array('posts' => $posts);
        return response()->json($data);
    }

    public function showdeleg(Request $request)
    {
        $deleg_id=$request->id;
        $posts=DB::table("posts")->where([
            ['type' , 'like' , '%'.'%'],
            ['delegation_id', '=', $deleg_id]
        ])->paginate(10);
        $data = array('posts' => $posts);
        return response()->json($data);
    }

    public function editShow(Request $request) {
        $id = $request['id'];
        $etat= $request['affichage'];
        if($etat=='true') {$affichage = 0;}
        else{$affichage=1;}
        DB::update('update posts set affichage = ? where id = ?',[$affichage,$id]);
    }

    public function searchall(Request $request)
    {
        $search = $request['search'];
        $posts=DB::table("posts")->where([
            ['description' , 'like' , '%'.$search.'%'],
            ['affichage','=','1'],
            ]
        )->paginate(10);
        //return view('index',['posts' => $posts]) ;
        $data = array('posts' => $posts);
        return response()->json($data);
    }

    public function searchdeleg(Request $request)
    {
        $search = $request['search'];
        $deleg_id=$request->id;
        $posts=DB::table("posts")->where([
            ['description' , 'like' , '%'.$search.'%'],
            ['affichage','=','1'],
            ['delegation_id', '=', $deleg_id]
        ])->paginate(10);
        //return view('index',['posts' => $posts]) ;
        $data = array('posts' => $posts);
        return response()->json($data);
    }

}
