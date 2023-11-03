<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\BlogContent;

class BlogApiController extends ApiController
{

    /**
     * @OA\Get(
     *      path="/blogs",
     *      operationId="getBlogsList",
     *      tags={"Blogs"},
     *      summary="Get list of Blogs",
     *      description="Returns list of blogs",
     *      security={{"sanctum": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        return Blog::take(20)->orderBy('id', 'desc')->get();
    }

    /**
     * Display the create form
     */
    public function create() {
        return response('blog create view', 201);
    }

    /**
     * @OA\Post(
     *     path="/blogs",
     *     tags={"Blogs"},
     *     summary="Store Blog",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody (
     *         required=true,
     *         @OA\MediaType (
     *             mediaType="multipart/form-data",
     *             @OA\Schema (
     *                 @OA\Property ( property="title", type="string"),
     *                 @OA\Property ( property="short_desc", type="string"),
     *                 @OA\Property ( property="content", type="string"),
     *                 @OA\Property ( property="slug", type="string"),
     *                 @OA\Property ( property="image", type="file"),
     *                 @OA\Property ( property="meta_title", type="string"),
     *                 @OA\Property ( property="meta_desc", type="string"),
     *                 @OA\Property ( property="status", type="number"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response  ( response=200, description="Successful operation" ),
     *     @OA\Response  ( response=401, description="Unauthenticated", ),
     *     @OA\Response  ( response=403, description="Forbidden" ),
     * )
     */
    public function store(StoreBlogRequest $request)
    {
        $image_path = $request->has('image')
            ? $request->file('image')->store('blog', 'public') : '';

        $blog_content =  BlogContent::create(['content' => $request['content']]);
        unset($request['content']);

        $data = $request->all();
        $data['blog_content_id']    = $blog_content->id;
        $data['author_id']          = auth()->user()->id;
        $data['image']              = $image_path;


        $blog = Blog::create($data);

        return response($blog);
    }

    /**
     * @OA\Get(
     *      path="/blogs/{id}",
     *      operationId="getBlog",
     *      tags={"Blogs"},
     *      summary="Get Blog with full content",
     *      description="Returns list of blogs",
     *      security={{"sanctum": {}}},
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          @OA\Schema (
     *              type="string"
     *          )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function show(string $id)
    {
        return Blog::with(['content'])->find($id);
    }

    /**
     * Display the edit form
     */
    public function edit(string $id) {
        return Blog::find($id);
    }

    /**
     * @OA\Post(
     *     path="/blogs/{id}",
     *     operationId="updateBlog",
     *     tags={"Blogs"},
     *     summary="Update Blog",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          @OA\Schema (
     *              type="integer"
     *          )
     *     ),
     *     @OA\RequestBody (
     *         required=true,
     *         @OA\MediaType (
     *             mediaType="multipart/form-data",
     *             @OA\Schema (
     *                 @OA\Property ( property="title", type="string"),
     *                 @OA\Property ( property="short_desc", type="string"),
     *                 @OA\Property ( property="content", type="string"),
     *                 @OA\Property ( property="slug", type="string"),
     *                 @OA\Property ( property="image", type="file"),
     *                 @OA\Property ( property="meta_title", type="string"),
     *                 @OA\Property ( property="meta_desc", type="string"),
     *                 @OA\Property ( property="status", type="number"),
     *                 @OA\Property ( property="_method", type="string", default="'PUT",),
     *             ),
     *         ),
     *     ),
     *     @OA\Response  ( response=200, description="Successful operation" ),
     *     @OA\Response  ( response=401, description="Unauthenticated", ),
     *     @OA\Response  ( response=403, description="Forbidden" ),
     * )
     */
    public function update(UpdateBlogRequest $request, string $id)
    {

        $image_path = $request->has('image')
            ? $request->file('image')->store('blog', 'public') : '';

        $blog_content = $request->has('content') ? BlogContent::create(['content' => $request['content']]):'';
        unset($request['content']);

        $data = $request->all();
        $data['blog_content_id']    = $blog_content->id;
        $data['author_id']          = auth()->user()->id;
        $data['image']              = $image_path;

        $succes = Blog::find($id)->update($data);
        return response(['blog' => $data, 'succes' => (bool)$succes]);
    }

    /**
     * @OA\Delete(
     *      path="/blogs/{id}",
     *      operationId="deleteBlog",
     *      tags={"Blogs"},
     *      summary="Delete Blog",
     *      description="Returns list of blogs",
     *      security={{"sanctum": {}}},
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          @OA\Schema (
     *              type="integer"
     *          )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function destroy(string $id)
    {
        return Blog::find($id)->delete();
    }
}
