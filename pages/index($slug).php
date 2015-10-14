<?php
$data = DB::selectOne('select * from posts where slug = ?',$slug);
if (!$data) Router::redirect('error/not_found');

if (preg_match('/\r?\n---+\r?\n/', $data['posts']['content'])) {
	list($data['posts']['html'],$data['posts']['more_html']) = preg_split('/\r?\n---+\r?\n/', $data['posts']['content'], 2);
} else {
	list($data['posts']['html'],$data['posts']['more_html']) = array($data['posts']['content'], '');
}
Buffer::set('content',Michelf\Markdown::defaultTransform($data['posts']['html']));
Buffer::set('more_content',Michelf\Markdown::defaultTransform($data['posts']['more_html']));