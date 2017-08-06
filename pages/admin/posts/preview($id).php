<?php
$data = DB::selectOne('SELECT * from posts,users where user_id = users.id and posts.id = ?', $id);

if ($pos=strpos($data['posts']['content'],'(...)')) {
    $data['posts']['html'] = substr($data['posts']['content'], 0, $pos).'...';
	$data['posts']['more_html'] = true;
	$data['posts']['content'] = substr_replace($data['posts']['content'], '', $pos, 5);
	$data['posts']['description'] = substr($data['posts']['content'],0,$pos).'...';
} else if ($pos = strpos($data['posts']['content'],' ',200)) {
	$data['posts']['html'] = substr($data['posts']['content'], 0, $pos).'...';
	$data['posts']['more_html'] = true;
	$data['posts']['description'] = substr($data['posts']['content'],0,$pos).'...';
} else {
	$data['posts']['html'] = $data['posts']['content'];
	$data['posts']['more_html'] = false;
	$data['posts']['description'] = $data['posts']['content'];
}
$title = $data['posts']['title'];

Buffer::set("content_html",trim(Michelf\Markdown::defaultTransform($data['posts']['html'])));
Buffer::set('content',Michelf\Markdown::defaultTransform($data['posts']['content']));
