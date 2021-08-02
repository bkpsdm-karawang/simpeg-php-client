<?php

namespace SimpegClient\Laravel\Http\Controllers;

use SimpegClient\Laravel\Facades\SimpegClient;

class PegawaiController extends Controller
{
    /**
     * constructor.
     */
    public function __construct(SimpegClient $manager)
    {
        $this->client = $manager::module('pegawai');
    }
}
