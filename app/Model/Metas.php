<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Metas extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'referrer',
        'description',
        'keywords',
        'author',
        'theme_color',
        'og_title',
        'og_image',
        'og_url',
        'og_site_name',
        'og_description',
        'fb_app_id',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_url',
        'twitter_image',
        'parsely_link',
        'bookID'
    ];

    public function add($data)
    {
        return DB::table('metas')->insert($data);
    }

    public function book(){
        return $this->belongsTo('App\Model\Book','id','bookID');
    }

    public function getAll() {
        return DB::table('metas')->get();
    }

    public function getItem($id) {
        return DB::table('metas')->where('id', $id)->first();
    }

    public function getItemByBookID($bookID) {
        return DB::table('metas')->where('bookID', $bookID)->first();
    }

    public function updateById($id, $data)
    {
        return DB::table('metas')->where('id', $id)->update([
            'id' => $data[0]['id'],
            'title' => $data[0]['title'],
            'referrer' => $data[0]['referrer'],
            'description' => $data[0]['description'],
            'keywords' => $data[0]['keywords'],
            'author' => $data[0]['author'],
            'theme_color' => $data[0]['theme_color'],
            'og_title' => $data[0]['og_title'],
            'og_image' => $data[0]['og_image'],
            'og_url' => $data[0]['og_url'],
            'og_site_name' => $data[0]['og_site_name'],
            'og_description' => $data[0]['og_description'],
            'fb_app_id' => $data[0]['fb_app_id'],
            'twitter_card' => $data[0]['twitter_card'],
            'twitter_title' => $data[0]['twitter_title'],
            'twitter_description' => $data[0]['twitter_description'],
            'twitter_url' => $data[0]['twitter_url'],
            'twitter_image' => $data[0]['twitter_image'],
            'parsely_link' => $data[0]['parsely_link'],
            'bookID' => $data[0]['bookID']
        ]);
    }
}