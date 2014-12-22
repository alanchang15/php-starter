<?php

App::before('start', function()
{

});

App::after('start', function(&$params, &$output)
{

});

// Event::register('after.render', function($output)
// {
//     return str_replace('Welcome', 'Test Welcome', $output);
// });

App::after('render', function(&$params, &$output)
{
    $output = str_replace('Welcome', 'Test Welcome', $output);
});