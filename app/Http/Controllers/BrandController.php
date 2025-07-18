<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Models\Lang;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public $title = 'Баннеры';
    public $route_name = 'banners';
    public $route_parameter = 'banner';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::latest()
            ->paginate(12);
        $languages = Lang::all();

        return view('app.brands.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'brands' => $brands,
            'languages' => $languages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langs = Lang::all();

        return view('app.brands.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => $langs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Video faylni tekshirish va saqlash
        if ($request->hasFile('url')) {
            $video = $request->file('url');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $videoPath = $video->storeAs('videos', $videoName, 'public'); // storage/app/public/videos/
            $data['url'] = $videoPath;
        }

        $data['slug'] = Str::slug($data['title'][$this->main_lang->code], '-');
        if(Brand::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'].'-'.time();
        }
        // Dropzone rasmlari bo‘lsa, ularni qo‘shish
        if (isset($data['dropzone_images'])) {
            $data['img'] = $data['dropzone_images'];
        }

        Brand::create($data);

        return redirect()->route('banners.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $langs = Lang::all();
        $brand = Brand::find($id);


        return view('app.brands.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => $langs,
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $data = $request->all();

        // 1. Yangi video fayl bo‘lsa
        if ($request->hasFile('url')) {
            $video = $request->file('url');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $videoPath = 'videos/' . $videoName;

            // Eski videoni o‘chirish
            if ($brand->url && file_exists(public_path($brand->url))) {
                unlink(public_path($brand->url));
            }

            $video->move(public_path('videos'), $videoName);
            $data['url'] = $videoPath;
        }
        // 2. Foydalanuvchi videoni o‘chirishni belgilagan bo‘lsa
        elseif ($request->has('delete_video')) {
            if ($brand->url && file_exists(public_path($brand->url))) {
                unlink(public_path($brand->url));
            }
            $data['url'] = null;
        }
        // 3. Hech narsa qilinmasa, eski URLni o‘z holida qoldiramiz
        else {
            $data['url'] = $brand->url;
        }

        // Dropzone rasmlari
        if (isset($data['dropzone_images'])) {
            $data['img'] = $data['dropzone_images'];
        }

        $brand->update($data);

        return redirect()->route('banners.index')->with([
            'success' => true,
            'message' => 'Успешно обновлен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Sertifikatni id orqali topish
        $brand = Brand::find($id);

        // Agar sertifikat mavjud bo'lmasa, xatolik xabarini ko'rsatish
        if (!$brand) {
            return back()->with([
                'success' => false,
                'message' => 'что найдено'
            ]);
        }

        // Sertifikatni o'chirish
        $brand->delete();

        // Qayta yo'naltirish va muvaffaqiyat xabarini ko'rsatish
        return back()->with([
            'success' => true,
            'message' => 'Успешно удалено'
        ]);}
}
