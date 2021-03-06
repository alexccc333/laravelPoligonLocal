<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class PostController extends BaseController
{
    private $blogPostRepository;

    private $blogCategoryRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
       $item = new BlogPost();
       $categoryList = $this->blogCategoryRepository->getForComboBox();


       return view('blog.admin.posts.edit',compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if ($item)
        {
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);
            return redirect()->route('blog.admin.posts.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        }

        return back()
            ->withErrors(['msg' => "Ошибка сохранения"])
            ->withInput();
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if (empty($item)){
            return back()->withErrors(['msg'=>"Запись id=[{id}] не найдена"])->withInput();
        }

        $data = $request->all();

        $result = $item->update($data);

        if($result){
            return redirect()->route('blog.admin.posts.edit',$item->id)->with(['success'=>'Успешно сохраннено']);
        }
        else{
            return back()->withErrors(['msg'=>"Ошибка инцализации"])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {

        $result = BlogPost::destroy($id);

//       $result= BlogPost::find($id)->forceDelete();
        if ($result){
            BlogPostAfterDeleteJob::dispatch($id)->delay(30);

//            BlogPostAfterDeleteJob::dispatchNow($id);
//            dispatch(new BlogPostAfterDeleteJob($id))->delay(20);

            return redirect()->route('blog.admin.posts.index')
                ->with(['success'=>"Запись id[$id] удаленна"]);
        }
        else{
            return back()->withErrors(['msg'=>'Ошибка удаления']);
        }
    }
}
