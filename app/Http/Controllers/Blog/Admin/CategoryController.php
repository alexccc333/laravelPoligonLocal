<?php

namespace App\Http\Controllers\Blog\Admin;


use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CategoryController extends BaseController {

    private $blogCategotyRepository;

    public function __construct()
    {
        parent::__construct();

        $this->blogCategotyRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);

        $paginator = $this->blogCategotyRepository->getAllWithPaginate(5);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList = $this->blogCategotyRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        if (empty($data['slug']))
        {
            $data['slug'] = str_slug($data['title']);
        }

        $item = new BlogCategory($data);
        $item->save();


        if ($item)
        {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else
        {
            return back()
                ->withErrors(['msg' => "Ошибка сохранения"])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        dd(__METHOD__);
    }


    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id, BlogCategoryRepository $categoryRepository)
    {
        $item = $this->blogCategotyRepository->getEdit($id);
        if (empty($item))
        {
            abort(404);
        }

        $categoryList = $categoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {


        $item = $this->blogCategotyRepository->getEdit($id);

        if (empty($item))
        {
            return back()
                ->withErrors(['msg' => "Запись if=[{$id}] ненайдена"])
                ->withInput();
        }
        $data = $request->all();

        if (empty($data['slug']))
        {
            $data['slug'] = str_slug($data['title']);
        }

        $result = $item->update($data);

        if ($result)
        {
            return redirect()->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else
        {
            return back()
                ->withErrors(['msg' => "Ошибка сохранения"])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        dd(__METHOD__);
    }
}
