<?php

it('returns a redirect response to dashboard', function () {
    $response = $this->get('/');

    $response->assertRedirect('/dashboard');
});
