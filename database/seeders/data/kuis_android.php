<?php
return [
    17 => [
        'title' => 'Kuis Android Dasar',
        'description' => 'Menilai pemahaman dasar tentang pengembangan aplikasi Android',
        'questions' => [
            ['Bahasa pemrograman utama untuk Android adalah...', ['Java' => true, 'C++' => false, 'Python' => false, 'JavaScript' => false]],
            ['IDE resmi untuk pengembangan Android adalah...', ['Android Studio' => true, 'Eclipse' => false, 'NetBeans' => false, 'Visual Studio' => false]],
            ['Layout Android ditulis dalam format...', ['XML' => true, 'HTML' => false, 'JSON' => false, 'YAML' => false]],
            ['Activity di Android adalah...', ['Komponen UI utama' => true, 'Database' => false, 'Service background' => false, 'Broadcast receiver' => false]],
            ['Manifest file di Android berfungsi untuk...', ['Mendeklarasikan komponen aplikasi' => true, 'Menyimpan data pengguna' => false, 'Menjalankan service' => false, 'Mengatur layout' => false]],
        ],
    ],
    18 => [
        'title' => 'Kuis Android UI dan Layout',
        'description' => 'Menilai kemampuan mendesain UI aplikasi Android',
        'questions' => [
            ['Komponen UI untuk menampilkan teks adalah...', ['TextView' => true, 'Button' => false, 'EditText' => false, 'ImageView' => false]],
            ['Untuk membuat tombol di Android, kita gunakan...', ['Button' => true, 'TextView' => false, 'ImageView' => false, 'EditText' => false]],
            ['Layout yang mengatur elemen secara vertikal adalah...', ['LinearLayout' => true, 'RelativeLayout' => false, 'ConstraintLayout' => false, 'GridLayout' => false]],
            ['Untuk menampilkan gambar, kita gunakan...', ['ImageView' => true, 'TextView' => false, 'Button' => false, 'EditText' => false]],
            ['Komponen untuk input teks adalah...', ['EditText' => true, 'TextView' => false, 'Button' => false, 'ImageView' => false]],
        ],
    ],
    19 => [
        'title' => 'Kuis Android Activity dan Intent',
        'description' => 'Menilai pemahaman tentang Activity dan Intent di Android',
        'questions' => [
            ['Intent digunakan untuk...', ['Memulai Activity lain' => true, 'Menyimpan data' => false, 'Mengatur layout' => false, 'Menjalankan service' => false]],
            ['Activity yang ditampilkan di atas Activity lain disebut...', ['Dialog' => true, 'Fragment' => false, 'Service' => false, 'Broadcast receiver' => false]],
            ['Intent untuk mengirim data ke Activity lain adalah...', ['Explicit intent' => true, 'Implicit intent' => false, 'Broadcast intent' => false, 'Service intent' => false]],
            ['Untuk menerima hasil dari Activity lain, kita gunakan...', ['startActivityForResult()' => true, 'startActivity()' => false, 'startService()' => false, 'sendBroadcast()' => false]],
            ['Lifecycle method yang dipanggil saat Activity dibuat adalah...', ['onCreate()' => true, 'onStart()' => false, 'onResume()' => false, 'onPause()' => false]],
        ],
    ],
    20 => [
        'title' => 'Kuis Android Database dan Content Provider',
        'description' => 'Menilai kemampuan mengelola data menggunakan SQLite dan Content Provider',
        'questions' => [
            ['SQLite adalah...', ['Database relasional ringan' => true, 'NoSQL database' => false, 'In-memory database' => false, 'Distributed database' => false]],
            ['Untuk menyimpan data di SQLite, kita gunakan...', ['ContentValues' => true, 'Cursor' => false, 'Intent' => false, 'Bundle' => false]],
            ['Content Provider digunakan untuk...', ['Berbagi data antar aplikasi' => true, 'Menyimpan data lokal' => false, 'Menjalankan background task' => false, 'Mengatur UI' => false]],
            ['Cursor digunakan untuk...', ['Mengambil data dari database' => true, 'Menyimpan data' => false, 'Menampilkan UI' => false, 'Mengirim intent' => false]],
            ['Untuk mengupdate data di SQLite, kita gunakan...', ['update()' => true, 'insert()' => false, 'delete()' => false, 'query()' => false]],
        ],
    ],
    21 => [
        'title' => 'Kuis Android Networking dan API',
        'description' => 'Menilai kemampuan mengakses API menggunakan Retrofit dan Volley',
        'questions' => [
            ['Retrofit adalah...', ['Library untuk HTTP client' => true, 'Database library' => false, 'UI library' => false, 'Testing library' => false]],
            ['Untuk mengirim request POST di Retrofit, kita gunakan...', ['@POST' => true, '@GET' => false, '@PUT' => false, '@DELETE' => false]],
            ['Volley digunakan untuk...', ['Networking di Android' => true, 'Database management' => false, 'UI rendering' => false, 'Background processing' => false]],
            ['Untuk mengatur request timeout di Volley, kita gunakan...', ['setRetryPolicy()' => true, 'setTimeout()' => false, 'setRequest()' => false, 'setPolicy()' => false]],
            ['Response dari API di Retrofit biasanya berupa...', ['POJO class' => true, 'String' => false, 'XML' => false, 'Bitmap' => false]],
        ],
    ],
    22 => [
        'title' => 'Kuis Android Service dan Broadcast Receiver',
        'description' => 'Menilai pemahaman tentang Service dan Broadcast Receiver di Android',
        'questions' => [
            ['Service digunakan untuk...', ['Menjalankan tugas background' => true, 'Menampilkan UI' => false, 'Mengelola database' => false, 'Mengirim broadcast' => false]],
            ['Broadcast Receiver digunakan untuk...', ['Menerima pesan dari sistem' => true, 'Menjalankan service' => false, 'Mengelola UI' => false, 'Menyimpan data' => false]],
            ['IntentService adalah...', ['Service dengan thread terpisah' => true, 'UI thread' => false, 'Background task' => false, 'Broadcast receiver' => false]],
            ['Untuk mendaftar Broadcast Receiver di manifest, kita gunakan...', ['<receiver> tag' => true, '<service> tag' => false, '<activity> tag' => false, '<provider> tag' => false]],
            ['Lifecycle method yang dipanggil saat Service dimulai adalah...', ['onStartCommand()' => true, 'onCreate()' => false, 'onDestroy()' => false, 'onBind()' => false]],
        ],
    ],
    23 => [
        'title' => 'Kuis Android Fragment dan Navigation',
        'description' => 'Menilai kemampuan menggunakan Fragment dan Navigation Component',
        'questions' => [
            ['Fragment adalah...', ['Bagian dari UI yang dapat digunakan kembali' => true, 'Activity baru' => false, 'Service baru' => false, 'Broadcast receiver baru' => false]],
            ['Untuk mengganti Fragment di Activity, kita gunakan...', ['FragmentTransaction' => true, 'Intent' => false, 'Bundle' => false, 'ViewModel' => false]],
            ['Navigation Component memudahkan...', ['Navigasi antar Fragment' => true, 'Database management' => false, 'Networking' => false, 'UI rendering' => false]],
            ['Untuk mengirim data antar Fragment, kita gunakan...', ['Bundle' => true, 'Intent' => false, 'SharedPreferences' => false, 'SQLite' => false]],
            ['Lifecycle method yang dipanggil saat Fragment dibuat adalah...', ['onCreateView()' => true, 'onCreate()' => false, 'onStart()' => false, 'onResume()' => false]],
        ],
    ],
    24 => [
        'title' => 'Kuis Android Testing dan Debugging',
        'description' => 'Menilai kemampuan melakukan testing dan debugging aplikasi Android',
        'questions' => [
            ['Unit test digunakan untuk...', ['Menguji logika kode' => true, 'UI testing' => false, 'Integration testing' => false, 'Performance testing' => false]],
            ['Espresso digunakan untuk...', ['UI testing di Android' => true, 'Database testing' => false, 'Network testing' => false, 'Unit testing' => false]],
            ['Untuk debugging aplikasi, kita gunakan...', ['Logcat' => true, 'SQLite' => false, 'SharedPreferences' => false, 'Intent' => false]],
            ['JUnit digunakan untuk...', ['Unit testing di Java' => true, 'UI testing' => false, 'Network testing' => false, 'Integration testing' => false]],
            ['Untuk menangkap exception di Android, kita gunakan...', ['try-catch block' => true, 'if-else statement' => false, 'switch-case statement' => false, 'for loop' => false]],
        ],
    ],
    25 => [
        'title' => 'Kuis Android Material Design',
        'description' => 'Menilai pemahaman tentang prinsip Material Design di Android',
        'questions' => [
            ['Material Design adalah...', ['Panduan desain UI dari Google' => true, 'Framework CSS' => false, 'Database library' => false, 'Testing library' => false]],
            ['Komponen Material Design untuk tombol adalah...', ['MaterialButton' => true, 'Button' => false, 'TextView' => false, 'ImageView' => false]],
            ['Untuk menggunakan Material Design, kita perlu menambahkan...', ['Material Components library' => true, 'Retrofit library' => false, 'Volley library' => false, 'Room library' => false]],
            ['Theme Material Design biasanya dimulai dengan...', ['@style/Theme.MaterialComponents' => true, '@style/Theme.AppCompat' => false, '@style/Theme.Holo' => false, '@style/Theme.DeviceDefault' => false]],
            ['Komponen Material Design untuk dialog adalah...', ['MaterialAlertDialogBuilder' => true, 'AlertDialog' => false, 'DialogFragment' => false, 'BottomSheetDialog' => false]],
        ],
    ],
    26 => [
        'title' => 'Kuis Android Firebase Integration',
        'description' => 'Menilai kemampuan mengintegrasikan Firebase ke dalam aplikasi Android',
        'questions' => [
            ['Firebase digunakan untuk...', ['Backend as a Service' => true, 'Database lokal' => false, 'UI library' => false, 'Testing library' => false]],
            ['Untuk menyimpan data di Firebase Realtime Database, kita gunakan...', ['FirebaseDatabase' => true, 'SQLiteDatabase' => false, 'SharedPreferences' => false, 'ContentProvider' => false]],
            ['Firebase Authentication digunakan untuk...', ['Otentikasi pengguna' => true, 'Database management' => false, 'UI rendering' => false, 'Networking' => false]],
            ['Untuk mengirim notifikasi push, kita gunakan...', ['Firebase Cloud Messaging' => true, 'Firebase Storage' => false, 'Firebase Hosting' => false, 'Firebase Functions' => false]],
            ['Untuk menyimpan file di Firebase Storage, kita gunakan...', ['StorageReference' => true, 'DatabaseReference' => false, 'Query' => false, 'DocumentReference' => false]],
        ],
    ],
    27 => [
        'title' => 'Kuis Android Performance Optimization',
        'description' => 'Menilai kemampuan mengoptimalkan performa aplikasi Android',
        'questions' => [
            ['Untuk mengurangi penggunaan memori, kita gunakan...', ['BitmapFactory.Options' => true, 'AsyncTask' => false, 'Handler' => false, 'IntentService' => false]],
            ['Untuk mengoptimalkan loading gambar, kita gunakan...', ['Glide/Picasso library' => true, 'AsyncTask' => false, 'Thread' => false, 'Handler' => false]],
            ['Untuk mengurangi lag saat scrolling, kita gunakan...', ['RecyclerView' => true, 'ListView' => false, 'GridView' => false, 'ScrollView' => false]],
            ['Untuk mengoptimalkan query database, kita gunakan...', ['Indexing' => true, 'Normalization' => false, 'Denormalization' => false, 'Partitioning' => false]],
            ['Untuk mengurangi penggunaan bandwidth, kita gunakan...', ['Compression' => true, 'Encryption' => false, 'Decryption' => false, 'Encoding' => false]],
        ],
    ],
    28 => [
        'title' => 'Kuis Android Security Best Practices',
        'description' => 'Menilai pemahaman tentang praktik keamanan terbaik dalam pengembangan aplikasi Android',
        'questions' => [
            ['Untuk menyimpan data sensitif, kita gunakan...', ['EncryptedSharedPreferences' => true, 'PlainSharedPreferences' => false, 'SQLiteDatabase' => false, 'FileStorage' => false]],
            ['Untuk mengamankan komunikasi jaringan, kita gunakan...', ['HTTPS/TLS' => true, 'HTTP' => false, 'FTP' => false, 'SMTP' => false]],
            ['Untuk mencegah reverse engineering, kita gunakan...', ['ProGuard/R8' => true, 'Obfuscation' => false, 'Encryption' => false, 'Compression' => false]],
            ['Untuk mengamankan API key, kita gunakan...', ['BuildConfig/gradle.properties' => true, 'Hardcode di kode' => false, 'SharedPreferences' => false, 'SQLiteDatabase' => false]],
            ['Untuk mencegah SQL injection, kita gunakan...', ['PreparedStatement' => true, 'String concatenation' => false, 'Raw query' => false, 'Dynamic query' => false]],
        ],
    ],
    29 => [
        'title' => 'Kuis Android Deployment dan Distribution',
        'description' => 'Menilai pemahaman tentang proses deployment dan distribusi aplikasi Android',
        'questions' => [
            ['Untuk mendistribusikan aplikasi Android, kita gunakan...', ['APK file' => true, 'EXE file' => false, 'DMG file' => false, 'ZIP file' => false]],
            ['Untuk mengupload aplikasi ke Google Play Store, kita perlu...', ['Membuat akun developer' => true, 'Membuat akun Gmail' => false, 'Membuat akun Facebook' => false, 'Membuat akun Twitter' => false]],
            ['Untuk menandatangani APK, kita gunakan...', ['Keystore file' => true, 'JKS file' => false, 'P12 file' => false, 'CER file' => false]],
            ['Untuk mengoptimalkan ukuran APK, kita gunakan...', ['APK split' => true, 'ProGuard' => false, 'R8' => false, 'DexGuard' => false]],
            ['Untuk mengupdate aplikasi di Google Play Store, kita perlu...', ['Mengupload versi baru APK' => true, 'Menghapus versi lama' => false, 'Mengganti nama paket' => false, 'Mengganti ikon aplikasi' => false]],
        ],
    ],
    30 => [
        'title' => 'Kuis Android Best Practices',
        'description' => 'Menilai pemahaman tentang praktik terbaik dalam pengembangan aplikasi Android',
        'questions' => [
            ['Untuk mengelola dependensi, kita gunakan...', ['Gradle' => true, 'Maven' => false, 'Ant' => false, 'Ivy' => false]],
            ['Untuk menghindari memory leak, kita gunakan...', ['WeakReference' => true, 'StrongReference' => false, 'SoftReference' => false, 'PhantomReference' => false]],
            ['Untuk mengelola konfigurasi aplikasi, kita gunakan...', ['BuildConfig' => true, 'Manifest' => false, 'Gradle' => false, 'XML' => false]],
            ['Untuk menguji aplikasi di berbagai perangkat, kita gunakan...', ['Firebase Test Lab' => true, 'Android Emulator' => false, 'Genymotion' => false, 'BlueStacks' => false]],
            ['Untuk mengelola versi aplikasi, kita gunakan...', ['VersionCode dan VersionName' => true, 'BuildType' => false, 'Flavor' => false, 'SigningConfig' => false]],
        ],
    ],
    31 => [
        'title' => 'Kuis Android Kotlin Basics',
        'description' => 'Menilai pemahaman dasar tentang bahasa pemrograman Kotlin untuk Android',
        'questions' => [
            ['Kotlin adalah...', ['Bahasa pemrograman statis' => true, 'Bahasa pemrograman dinamis' => false, 'Bahasa pemrograman fungsional' => false, 'Bahasa pemrograman imperatif' => false]],
            ['Untuk mendeklarasikan variabel di Kotlin, kita gunakan...', ['val dan var' => true, 'let dan const' => false, 'final dan static' => false, 'const dan var' => false]],
            ['Fungsi di Kotlin dideklarasikan dengan kata kunci...', ['fun' => true, 'function' => false, 'def' => false, 'func' => false]],
            ['Untuk menangani nullability di Kotlin, kita gunakan...', ['? dan !!' => true, '$$' => false, '@@' => false, '!!@' => false]],
            [
                'Kotlin mendukung...',
                ['Extension functions' => true, 'Operator overloading' => true, 'Lambda expressions' => true, 'Semua jawaban benar' => true],
            ],
        ],
    ],
    32 => [
        'title' => 'Kuis Android Kotlin Coroutines',
        'description' => 'Menilai pemahaman tentang penggunaan coroutines di Kotlin untuk Android',
        'questions' => [
            ['Coroutines digunakan untuk...', ['Asynchronous programming' => true, 'Synchronous programming' => false, 'Blocking I/O' => false, 'Thread management' => false]],
            ['Untuk menjalankan coroutine di Android, kita gunakan...', ['CoroutineScope' => true, 'ThreadPool' => false, 'ExecutorService' => false, 'HandlerThread' => false]],
            ['Untuk menunda eksekusi coroutine, kita gunakan...', ['delay()' => true, 'sleep()' => false, 'wait()' => false, 'pause()' => false]],
            ['Untuk menggabungkan beberapa coroutine, kita gunakan...', ['async() dan await()' => true, 'join() dan start()' => false, 'runBlocking()' => false, 'launch() dan cancel()' => false]],
            ['CoroutineScope di Android biasanya dideklarasikan di...', ['ViewModel' => true, 'Activity' => false, 'Fragment' => false, 'Service' => false]],
        ],
    ]
];
