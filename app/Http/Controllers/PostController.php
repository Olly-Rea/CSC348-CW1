<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

// Custom imports
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    // Variable for the number of News articles to get each time
    private $paginate = 12;

    /**
     * Method to load images for image-type 'Content'
     */
    public static function loadImage($path) {
        $imagePath = 'storage'.DIRECTORY_SEPARATOR.$path;
        // Check the file exists, and if so, output it, otherwise, return the image placeholder
        if (file_exists(public_path().DIRECTORY_SEPARATOR.$imagePath)) {
            return asset($imagePath);
        } else {
            clearstatcache();
            return asset('/images/graphics/image.svg');
        }
    }

    /**
     * Method to return the post feed
     */
    public function index() {
        // Get the first page of post results
        $posts = Post::orderBy('created_at', 'DESC')->paginate($this->paginate);
        // Return them in the feed view
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Method to fetch the next page of paginated data
     */
    public function fetch(Request $request) {
        // Check that the request is ajax
        if ($request->ajax()) {
            // Get the next page of paginated posts
            $posts = Post::orderBy('created_at', 'DESC')->paginate($this->paginate);
            // If $posts != null and is > 0...
            if($posts != null && count($posts) > 0) {
                // ...render the posts and return them to the feed
                return view('paginations.posts', ['posts' => $posts])->render();
            } else {
                return null;
            }
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to return the post feed
     */
    public function show(Post $post) {
        // Return them in the feed view
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Method to create new Post
     */
    public function create() {
        // Get the possible tags you can use in a post
        $tags = Tag::get();
        // The post/create view with tags
        return view('posts.create', ['tags' => $tags]);
    }

    /**
     * Method to save a post
     */
    public function save() {
        // // Check that the request is ajax
        // if ($request->ajax()) {

        // Ensure the user is logged in
        if(Auth::check()) {
            // Set Validator attribute names
            $attributeNames = array(
                'title' => 'Title',
                'tags[]' => 'Tags',
                'content[]' => 'Content',
            );
            // Validate the data
            Validator::make(request()->all(), [
                'title' => ['required', 'string', 'max:255'],
                'tags'    => ['array'],
                'tags.*'  => ['string', 'distinct'],
                'content'    => ['required', 'array', 'min:1'],
                'content.*'  => ['distinct'],
            ], [], $attributeNames)->validate();

            // Create the Post
            $post = Post::create([
                'user_id' => Auth::user()->id,
                'title' => request('title'),
                'published' => true,
            ]);

            // if the request has tags...
            if(request('tags')) {
                // Get and attach tags
                $tags = Tag::whereIn('name', request('tags'))->get();
                $post->tags()->attach($tags);
            }

            // Loop through all the Post 'content' in the form
            foreach(request('content') as $key => $rawContent) {
                // If the content isn't null
                if($rawContent != null) {
                    // Check If the content is an uploaded file (an image)
                    if(is_uploaded_file($rawContent)) {
                        // Set $image as the input file
                        $image = $rawContent;
                        // Set the content type as 'image'
                        $contentType = 'image';
                        // Set the imagePath
                        $imagePath = 'user_uploads/posts/' . $post->id . '/';
                        // Set the image name (with it's original extension)
                        $name = $image->getClientOriginalName();
                        // Get the full path, and move the file to that directory
                        $destinationPath = public_path() . '/storage/' . $imagePath;
                        $image->move($destinationPath, $name);
                        // Set the file path as content (to store in the database)
                        $content = $imagePath . $name;

                        // TODO add $subContent stuff
                        $subContent = null;
                    } else {
                        // Set the content type as 'text'
                        $contentType = 'text';
                        $content = $rawContent;
                        $subContent = null;
                    }
                    // Create the new content
                    $newContent = Content::create([
                        'post_id' => $post->id,
                        'position' => $key,
                        'type' => $contentType,
                        'content' => $content,
                        'sub_content' => $subContent
                    ]);
                    // Add the new content to the post
                    $post->content()->save($newContent);
                }
            }

            // redirect the user to the new post
            return redirect('/post/'.$post->id);

        // Else return a 404 not found error
        } else {
            abort(404);
        }

    }

    /**
     * Method to edit an existing Post
     */
    public static function edit(Post $post) {
        // Check a user is logged in (AND owns this post)
        if(Auth::check() && Auth::user()->id == $post->user->id) {
            // Get the possible tags you can use in a post
            $tags = Tag::get();
            // The post/edit view with tags
            return view('posts.edit', ['post' => $post, 'tags' => $tags]);
        } else {
            abort(403);
        }
    }

    /**
     * Method to persist the changes made to a post
     */
    public static function update(Post $post) {
        // Ensure the user is logged in
        if(Auth::check()) {
            // Set Validator attribute names
            $attributeNames = array(
                'title' => 'Title',
                'tags[]' => 'Tags',
                'content[][]' => 'Content',
            );
            // Validate the data
            Validator::make(request()->all(), [
                'title' => ['required', 'string', 'max:255'],
                'tags'    => ['array'],
                'tags.*'  => ['string', 'distinct'],
                'content'    => ['required', 'array', 'min:1'],
                'content.*'  => ['distinct'],
            ], [], $attributeNames)->validate();

            // Update the post
            $post->update([
                'title' => request('title'),
                'published' => true,
            ]);

            // if the request has tags...
            if(request('tags')) {
                // Get and attach tags
                $tags = Tag::whereIn('name', request('tags'))->get();
                $post->tags()->sync($tags);
            }

            // Get the (correct) length of items to rearrange
            $contentRequest = request('content');
            foreach($contentRequest as $key => $content) {
                if(!isset($content['id']) && isset($content['to_delete'])) {
                    unset($contentRequest[$key]);
                }
            }

            // Loop through all the posts and move them 'out of the way'
            $pos = count($contentRequest) + 1;
            foreach($post->content as $content) {
                $content->update([
                    'position' => $pos++
                ]);
            }

            $pos = 0;
            // Loop through all the Post 'content' in the form
            foreach($contentRequest as $editContent) {
                // If the Content isn't null
                if($editContent != null) {
                    // Check if the content already exists
                    if(isset($editContent['id'])) {
                        // get the Post Content to edit
                        $postContent = $post->content()->where('id', $editContent['id'])->first();
                        // Firstly, check if the content is to be deleted
                        if(isset($editContent['to_delete'])) {
                            // check if the Content type is an image
                            if($postContent->type == 'image') {
                                // Delete the stored file
                                Storage::delete($postContent->content);
                            }
                            // Delete the Content
                            $postContent->delete();
                            // Jump to next loop iteration
                            continue;
                        // Otherwise...
                        } else {
                            // Check if the $postContent position has changed
                            if($postContent->position != $key) {
                                // If so; set the new position of the content
                                $postContent->update([
                                    'position' => $pos++
                                ]);
                            }
                        }
                    } else {
                        if(!isset($editContent['to_delete'])) {
                            // Create the new content
                            $postContent = Content::create([
                                'post_id' => $post->id,
                                'position' => $pos++,
                                'type' => 'undefined',
                                'content' => $editContent['content'],
                            ]);
                            // Add the new content to the post
                            $post->content()->save($postContent);
                        }
                    }

                    // Check if the input has included content (image input is nullable)
                    if(isset($editContent['content'])) {
                        // Check If the content is an uploaded file (an image)
                        if(is_uploaded_file($editContent['content'])) {
                            // Delete the old file
                            Storage::delete($postContent->content);

                            // Set $image as the input file
                            $image = $editContent['content'];
                            // Set the imagePath
                            $imagePath = 'user_uploads/posts/' . $post->id . '/';
                            // Set the image name (with it's original extension)
                            $name = $image->getClientOriginalName();
                            // Get the full path, and move the file to that directory
                            $destinationPath = public_path() . '/storage/' . $imagePath;
                            $image->move($destinationPath, $name);
                            // Set the file path as content (to store in the database)
                            $content = $imagePath . $name;

                            // TODO add $subContent stuff

                            $subContent = null;

                            // Update the image content
                            $postContent->update([
                                'type' => 'image',
                                'content' => $content,
                                'sub_content' => $subContent
                            ]);
                        } else {
                            $content = $editContent['content'];
                            // Update the text content
                            $postContent->update([
                                'type' => 'text',
                                'content' => $content
                            ]);
                        }
                    }
                }
            }

            // Final check to ensure all content is in the correct position
            $pos = 0;
            foreach($post->content as $key => $content) {
                // Check the content position isn't already at '$pos'
                if($key != $pos++) {
                    $content->update([
                        'position' => $pos
                    ]);
                }
            }

            // redirect the user to the new post
            return redirect('/post/'.$post->id);

        // Else return a 404 not found error
        } else {
            abort(404);
        }

    }

    // Methods to add a text/image input to the post create/edit forms
    public static function addTextInput(Request $request) {
        if ($request->ajax()) {
            return view('posts.form.text', ['editing' => boolval($request->editing)])->render();
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }
    public static function addImageInput(Request $request) {
        if ($request->ajax()) {

            // dd($request->editing);

            return view('posts.form.image', ['editing' => boolval($request->editing)])->render();
        // Else return a 404 not found error
        } else {
            abort(404);
        }
    }

    /**
     * Method to delete a post
     */
    public static function delete(Post $post) {
        // Delete all the likes of a post
        $post->likes()->delete();
        // Delete the post
        $post->delete();
        // Redirect the user to the feed
        return redirect('feed');
    }

}

