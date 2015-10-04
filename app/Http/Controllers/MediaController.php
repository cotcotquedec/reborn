<?php namespace App\Http\Controllers;


use Models\Db;
use Models\Business;

class MediaController extends Controller
{

    /**
     * Try to sho a file in browser
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {

        try {
            /** @var Db\Media\Media $media */
            $media = Db\Media\Media::findOrFail($id);
        } catch(\Exception $e) {
            abort(404, 'Media doesn\'t exist : ' . $e->getMessage());
        }

        $attachment = $media->attachment()->first();

        return response($attachment->content, 200)
            ->header('Content-Type', $attachment->mime)
            ->header('Content-Length', $attachment->size);

    }


    /**
     * Force download the file
     *
     * @param $id
     * @return mixed
     */
    public function download($id)
    {
        try {
            /** @var Db\Media\Media $media */
            $media = Db\Media\Media::findOrFail($id);
        } catch(\Exception $e) {
            abort(404, 'Media doesn\'t exist : ' . $e->getMessage());
        }

        $attachment = $media->attachment()->first();

        return response($attachment->content, 200)
            ->header('Content-Disposition', sprintf('attachment; filename="%s"', $attachment->name))
            ->header('Content-Type', $attachment->mime)
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Content-Length', $attachment->size);
    }
}