@extends('layouts.app')


@section('content')
    <div class="container assetPage">
        <h4 class="title center"><?= $data['AVAIL:Title'] ?></h4>
        <p class="center">
            <?= $data['AVAIL:Description'] ?>
        </p>
        <div class="col-12">
        <img src="<?php
        foreach ($img['collection']['items'] as $image) {
            if(str_contains($image['href'],'jpg')) {
                echo $image['href'];
                break;
            }
        }
        ?>">
        </div>
    </div>
@endsection