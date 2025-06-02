@extends('layouts.admin')

@section('content')
    <style>
        /* Specific styles for this content area */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .content-header h1 {
            font-size: 24px;
            margin: 0;
        }
        .content-header .breadcrumbs {
            font-size: 14px;
            color: #666;
        }
        .content-header .breadcrumbs span {
            margin: 0 5px;
        }
        .content-header .breadcrumbs a {
            text-decoration: none;
            color: #007bff;
        }

        .article-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid #eee;
        }
        .article-card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f9f9f9;
        }
        .article-card-header h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .article-card-header .button {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .article-card-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }
        .article-card-body {
            padding: 20px;
        }
        .article-card-body h3 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .article-card-body p {
            font-size: 15px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
        }
        .article-card-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #eee;
            margin-top: 20px;
            background-color: #f9f9f9;
        }
    </style>
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-800">Berita</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.berita.index') }}" class="hover:text-custom-primary-red">Berita</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="article-card">
        <div class="article-card-header">
            <h2>Update Fitur Upload Baru!</h2>
            <a href="#" class="button">Terbitkan</a>
        </div>
        <img src="https://via.placeholder.com/900x250?text=Article+Image+1" alt="Article Image 1" class="article-card-image">
        <div class="article-card-body">
            <h3>Apa ini, aku juga bingung</h3>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                <br><br>
                Nullam ac tortor vitae purus faucibus tristique. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec eu nunc id dolor vestibulum lacinia. Cras at felis nec magna ultricies cursus. Mauris nec justo nec elit tempor interdum.
            </p>
            <img src="https://via.placeholder.com/900x250?text=Article+Image+2" alt="Article Image 2">
            <h3>Apa ini, aku juga bingung</h3>
            <p>
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                <br><br>
                Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
            </p>
            <img src="https://via.placeholder.com/900x250?text=Article+Image+3" alt="Article Image 3">
            <h3>Apa ini, aku juga bingung</h3>
            <p>
                Malis quis nonummy sed nam turpis. Et netus sit pellentesque suspendisse laoreet, diam, arcu, vel, pellentesque. Elementum non in est quam, aenean proin, sit adipiscing. Sit at, amet et ut curabitur, ut wisi lectus velit vel, magna. Non nec aenean ac tincidunt nam, at. Sed sit ut, aliquam sit diam nec, consectetuer pellentesque vel sed, mauris. Nibh diam donec neque at. Congue quisque est in, vestibulum at adipiscing nam.
                <br><br>
                Nibh id a in ac magna nulla. Eu et, volutpat est at, nulla nisl. Ornare lectus mi, neque diam. Sit sit massa, aliquam et non, in velit erat, nulla a. Non nec aenean ac tincidunt nam, at. Sed sit ut, aliquam sit diam nec, consectetuer pellentesque vel sed, mauris. Nibh diam donec neque at. Congue quisque est in, vestibulum at adipiscing nam. Ornare lectus mi, neque diam. Sit sit massa, aliquam et non, in velit erat, nulla a.
            </p>
        </div>
    </div>
@endsection