<?php

it('root redirects unauthenticated users to login', function () {
    $this->get('/')->assertRedirect('/login');
});
