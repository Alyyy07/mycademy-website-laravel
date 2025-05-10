<?php

return [
    1 => [
        'title' => 'Kuis Pengenalan IoT',
        'description' => 'Mengukur pemahaman dasar tentang Internet of Things (IoT)',
        'questions' => [
            ['Apa kepanjangan dari IoT?', ['Internet of Things' => true, 'Interface of Technology' => false, 'Input over Transmission' => false, 'Integrated Optical Transmitter' => false]],
            ['Perangkat manakah yang merupakan contoh IoT?', ['Smart TV' => true, 'Mesin Ketik' => false, 'Kipas Angin Manual' => false, 'Kalkulator' => false]],
            ['Komponen utama dalam sistem IoT adalah...', ['Sensor, jaringan, dan aktuator' => true, 'Harddisk, keyboard, dan monitor' => false, 'RAM, CPU, dan GPU' => false, 'CD-ROM, BIOS, dan casing' => false]],
            ['Protokol komunikasi yang umum digunakan dalam IoT adalah...', ['MQTT' => true, 'HTTP' => false, 'FTP' => false, 'SMTP' => false]],
            ['Apa yang dimaksud dengan sensor dalam konteks IoT?', ['Perangkat yang mengukur dan mengumpulkan data dari lingkungan' => true, 'Perangkat yang menyimpan data secara lokal' => false, 'Perangkat yang menampilkan data kepada pengguna' => false, 'Perangkat yang menghubungkan ke internet' => false]],
        ],
    ],
    2 => [
        'title' => 'Kuis Sensor dan Aktuator IoT',
        'description' => 'Menilai kemampuan mengidentifikasi sensor dan aktuator umum dalam IoT',
        'questions' => [
            ['Sensor apa yang umum dipakai untuk mengukur suhu?', ['DHT11' => true, 'LDR' => false, 'HC-SR04' => false, 'MQ-2' => false]],
            ['Aktuator apa yang mengubah sinyal listrik menjadi gerakan?', ['Servo motor' => true, 'Temperature sensor' => false, 'Light sensor' => false, 'Breadboard' => false]],
            ['Sensor kelembapan yang sering digunakan adalah...', ['DHT22' => true, 'BMP180' => false, 'IR sensor' => false, 'Ultrasonic sensor' => false]],
            ['Aktuator yang menghasilkan cahaya adalah...', ['LED' => true, 'Piezo buzzer' => false, 'Relay' => false, 'L298N' => false]],
            ['Fungsi aktuator dalam IoT adalah...', ['Menerjemahkan sinyal menjadi aksi fisik' => true, 'Menyimpan data' => false, 'Mengukur lingkungan' => false, 'Menyajikan data' => false]],
        ],
    ],
    3 => [
        'title' => 'Kuis ProtokoI Komunikasi IoT',
        'description' => 'Mengukur pemahaman tentang protokol MQTT, HTTP, dan CoAP',
        'questions' => [
            ['Apa kelebihan MQTT dibanding HTTP dalam IoT?', ['Lebih ringan dan efisien bandwidth' => true, 'Lebih aman' => false, 'Lebih lambat' => false, 'Tidak butuh broker' => false]],
            ['CoAP dirancang untuk...', ['Perangkat terbatas dan jaringan lossy' => true, 'Desktop computing' => false, 'Web browsing intensif' => false, 'Video streaming' => false]],
            ['Port default MQTT adalah...', ['1883' => true, '80' => false, '5683' => false, '443' => false]],
            ['HTTP menggunakan metode...', ['Request/response' => true, 'Publish/subscribe' => false, 'Store-and-forward' => false, 'Peer-to-peer' => false]],
            ['Broker MQTT bertugas...', ['Meneruskan pesan ke subscriber' => true, 'Menyimpan data sensor' => false, 'Menjalankan API' => false, 'Mengontrol aktuator' => false]],
        ],
    ],
    4 => [
        'title' => 'Kuis Topologi Jaringan IoT',
        'description' => 'Menilai kemampuan merancang topologi jaringan IoT sederhana',
        'questions' => [
            ['Topologi jaringan manakah yang paling tahan gangguan tunggal?', ['Mesh' => true, 'Bus' => false, 'Star' => false, 'Ring' => false]],
            ['Pada topologi star, perangkat terhubung ke...', ['Central hub' => true, 'Perangkat lain secara berurutan' => false, 'Bus utama' => false, 'Node edge' => false]],
            ['Kelebihan topologi mesh adalah...', ['Redundansi jalur' => true, 'Biaya rendah' => false, 'Mudah instalasi' => false, 'Sedikit kabel' => false]],
            ['Topologi yang ekonomis namun rawan single point failure adalah...', ['Bus' => true, 'Mesh' => false, 'Star' => false, 'Ring' => false]],
            ['Gambar skema jaringan IoT biasanya menggunakan simbol...', ['Node dan link' => true, 'Database dan tabel' => false, 'Flowchart' => false, 'Bar chart' => false]],
        ],
    ],
    5 => [
        'title' => 'Kuis Konfigurasi Mikrokontroler IoT',
        'description' => 'Menilai penguasaan setup dasar ESP32 untuk IoT',
        'questions' => [
            ['Bahasa pemrograman umum untuk ESP32 adalah...', ['C/C++' => true, 'Python' => false, 'Java' => false, 'Ruby' => false]],
            ['Toolchain resmi untuk ESP32 adalah...', ['ESP-IDF' => true, 'Arduino IDE' => false, 'PlatformIO' => false, 'MicroPython' => false]],
            ['Pin GPIO ESP32 dapat diatur sebagai...', ['Input dan output' => true, 'Hanya input' => false, 'Hanya output' => false, 'Analog saja' => false]],
            ['Untuk mengupload firmware ke ESP32, kita gunakan...', ['esptool.py' => true, 'avrdude' => false, 'openocd' => false, 'dfu-util' => false]],
            ['Baud rate default serial ESP32 adalah...', ['115200' => true, '9600' => false, '57600' => false, '4800' => false]],
        ],
    ],
    6 => [
        'title' => 'Kuis Pengiriman Data MQTT',
        'description' => 'Menilai kemampuan publish/subscribe data sensor ke broker MQTT',
        'questions' => [
            ['Perintah MQTT untuk mengirim pesan adalah...', ['PUBLISH' => true, 'SEND' => false, 'POST' => false, 'PUT' => false]],
            ['Topik MQTT bersifat...', ['Hierarkis' => true, 'Flat' => false, 'Unstructured' => false, 'Encrypted' => false]],
            ['QoS MQTT level 0 menjamin...', ['At most once' => true, 'At least once' => false, 'Exactly once' => false, 'No delivery' => false]],
            ['Broker MQTT default tidak menyimpan pesan jika...', ['Clean session true' => true, 'Persistent session' => false, 'Retain flag' => false, 'QoS 2' => false]],
            ['Client MQTT subscribe menggunakan perintah...', ['SUBSCRIBE' => true, 'LISTEN' => false, 'CONNECT' => false, 'JOIN' => false]],
        ],
    ],
    7 => [
        'title' => 'Kuis Dashboard IoT dengan Node-RED',
        'description' => 'Menilai kemampuan membuat dashboard monitoring real-time',
        'questions' => [
            ['Node dasar untuk input data MQTT di Node-RED adalah...', ['mqtt in' => true, 'http in' => false, 'inject' => false, 'function' => false]],
            ['Node untuk menampilkan grafik waktu nyata adalah...', ['chart' => true, 'ui_text' => false, 'debug' => false, 'template' => false]],
            ['Dashboard Node-RED diakses melalui port default...', ['1880' => true, '8080' => false, '3000' => false, '5000' => false]],
            ['Flow di Node-RED terdiri dari...', ['Node dan wire' => true, 'Class dan object' => false, 'Table dan row' => false, 'Function dan variable' => false]],
            ['Untuk menyimpan flow secara permanen, klik...', ['Deploy' => true, 'Save' => false, 'Run' => false, 'Export' => false]],
        ],
    ],
    8 => [
        'title' => 'Kuis Keamanan Dasar MQTT',
        'description' => 'Mengukur pemahaman tentang TLS/SSL pada MQTT',
        'questions' => [
            ['Untuk mengenkripsi koneksi MQTT, kita gunakan...', ['TLS/SSL' => true, 'SSH' => false, 'IPSec' => false, 'Kerberos' => false]],
            ['Port default MQTT over TLS adalah...', ['8883' => true, '1883' => false, '443' => false, '53' => false]],
            ['Sertifikat SSL terdiri dari...', ['Public key dan signature' => true, 'Private key saja' => false, 'Fingerprint saja' => false, 'Metadata saja' => false]],
            ['Mutual TLS artinya...', ['Client dan server verifikasi' => true, 'Hanya server verifikasi' => false, 'Hanya client verifikasi' => false, 'Tanpa verifikasi' => false]],
            ['Cara terbaik menyimpan credentials di IoT device adalah...', ['Secure element' => true, 'Hardcode di firmware' => false, 'Plain text file' => false, 'EEPROM tanpa enkripsi' => false]],
        ],
    ],
    9 => [
        'title' => 'Kuis Integrasi Cloud IoT',
        'description' => 'Menilai kemampuan mengirim data ke AWS IoT Core atau Azure IoT Hub',
        'questions' => [
            ['Endpoint AWS IoT Core menggunakan protokol...', ['MQTTS' => true, 'HTTPS' => false, 'FTP' => false, 'CoAP' => false]],
            ['Device certificate di AWS berbentuk...', ['X.509' => true, 'JWT' => false, 'OAuth' => false, 'API key' => false]],
            ['Untuk koneksi Azure IoT, kita butuh...', ['Connection string' => true, 'Access token' => false, 'SSH key' => false, 'API secret' => false]],
            ['Topic AWS untuk publish biasanya diawali dengan...', ['$aws' => true, 'iot' => false, 'device' => false, 'data' => false]],
            ['Retained message AWS IoT disimpan di broker jika...', ['Retain flag true' => true, 'Clean session' => false, 'QoS 0' => false, 'No flag' => false]],
        ],
    ],
    10 => [
        'title' => 'Kuis Dasar Data Processing IoT',
        'description' => 'Menilai pemahaman filter dan processing data real-time',
        'questions' => [
            ['Filter moving average berguna untuk...', ['Meratakan fluktuasi data' => true, 'Meningkatkan noise' => false, 'Mempercepat data' => false, 'Membalik sinyal' => false]],
            ['Window size 10 artinya...', ['10 sample per perhitungan' => true, '10 detik per sample' => false, '10 filter' => false, '10 thread' => false]],
            ['Fungsi median filter adalah...', ['Menghilangkan outlier' => true, 'Menambah outlier' => false, 'Menyimpan data mentah' => false, 'Membagi data' => false]],
            ['Data real-time butuh latency rendah karena...', ['Respons cepat sistem' => true, 'Akurasi rendah' => false, 'Batch processing' => false, 'High throughput' => false]],
            ['Algoritma smoothing lain selain moving average adalah...', ['Exponential smoothing' => true, 'Quick sort' => false, 'Merge sort' => false, 'Linear regression' => false]],
        ],
    ],
    11 => [
        'title' => 'Kuis Notifikasi Berbasis Kejadian IoT',
        'description' => 'Menilai kemampuan membuat alert email/WhatsApp berdasarkan event',
        'questions' => [
            ['Event-driven artinya...', ['Berdasarkan kejadian' => true, 'Berdasarkan jadwal' => false, 'Berdasarkan user' => false, 'Random' => false]],
            ['Protocol umum untuk alert WhatsApp adalah...', ['WhatsApp Business API' => true, 'SMTP' => false, 'MQTT' => false, 'FTP' => false]],
            ['Untuk email notification gunakan protocol...', ['SMTP' => true, 'MQTT' => false, 'CoAP' => false, 'SNMP' => false]],
            ['Payload JSON untuk email biasanya berisi field...', ['to, subject, body' => true, 'username, password' => false, 'host, port' => false, 'topic, qos' => false]],
            ['Webhook dipanggil ketika...', ['Event terjadi' => true, 'Cron job' => false, 'Startup' => false, 'Shutdown' => false]],
        ],
    ],
    12 => [
        'title' => 'Kuis Edge Computing IoT',
        'description' => 'Memahami konsep edge vs cloud computing',
        'questions' => [
            ['Edge computing memproses data di...', ['Perangkat terdekat sumber data' => true, 'Cloud server' => false, 'Data center pusat' => false, 'Browser user' => false]],
            ['Kelebihan edge computing adalah...', ['Latency rendah' => true, 'Skalabilitas tinggi' => false, 'Biaya murah' => false, 'Keamanan rendah' => false]],
            ['Cloud computing unggul di...', ['Storage besar' => true, 'Respons real-time' => false, 'Offline processing' => false, 'Edge device' => false]],
            ['Contoh device edge adalah...', ['Raspberry Pi' => true, 'AWS EC2' => false, 'Google Cloud' => false, 'Azure VM' => false]],
            ['Arsitektur hybrid edge-cloud disebut...', ['Fog computing' => true, 'Grid computing' => false, 'Peer-to-peer' => false, 'Client-server' => false]],
        ],
    ],
    13 => [
        'title' => 'Kuis Implementasi Edge Computing',
        'description' => 'Menilai kemampuan memproses data di perangkat edge',
        'questions' => [
            ['Library populer untuk edge AI di Python adalah...', ['TensorFlow Lite' => true, 'Scikit-learn' => false, 'PyTorch' => false, 'Pandas' => false]],
            ['Model dipangkas untuk edge agar...', ['Lebih ringan' => true, 'Lebih akurat' => false, 'Lebih kompleks' => false, 'Lebih lambat' => false]],
            ['Container untuk edge computing adalah...', ['Docker' => true, 'VMware' => false, 'VirtualBox' => false, 'KVM' => false]],
            ['Edge device sering menggunakan OS...', ['Linux Embedded' => true, 'Windows Server' => false, 'macOS' => false, 'Android' => false]],
            ['Batch inferencing di edge artinya...', ['Proses kumpulan data sekaligus' => true, 'Satu per satu' => false, 'Realtime' => false, 'Offline saja' => false]],
        ],
    ],
    14 => [
        'title' => 'Kuis REST API untuk IoT',
        'description' => 'Menilai kemampuan integrasi IoT dengan mobile apps via API',
        'questions' => [
            ['Method HTTP untuk mengambil data adalah...', ['GET' => true, 'POST' => false, 'PUT' => false, 'DELETE' => false]],
            ['Status code sukses untuk GET adalah...', ['200' => true, '404' => false, '500' => false, '301' => false]],
            ['Header untuk otorisasi biasanya...', ['Authorization' => true, 'Content-Type' => false, 'Accept' => false, 'Host' => false]],
            ['Endpoint REST bersih berarti...', ['Resource-based' => true, 'RPC-style' => false, 'SOAP' => false, 'GraphQL' => false]],
            ['Body JSON contoh: {"temperature":25} untuk...', ['Mengirim data sensor' => true, 'Menerima data user' => false, 'Login' => false, 'Delete resource' => false]],
        ],
    ],
    15 => [
        'title' => 'Kuis Studi Kasus IoT End-to-End',
        'description' => 'Menilai kemampuan mempresentasikan arsitektur solusi IoT',
        'questions' => [
            ['Tahap pertama dalam studi kasus adalah...', ['Analisis kebutuhan' => true, 'Deployment' => false, 'Monitoring' => false, 'Maintenance' => false]],
            ['Diagram arsitektur biasanya mencakup...', ['Device, network, cloud' => true, 'UI mockup' => false, 'Database schema' => false, 'Test plan' => false]],
            ['Use case utama IoT end-to-end adalah...', ['Pengumpulan data' => true, 'Render UI' => false, 'Compile code' => false, 'Design logo' => false]],
            ['Presentasi solusi sebaiknya menggunakan...', ['Slide dan demo' => true, 'Only code' => false, 'Only text' => false, 'Only images' => false]],
            ['Evaluasi akhir mencakup...', ['Kinerja dan keamanan' => true, 'Warna UI' => false, 'Nama file' => false, 'Ukuran font' => false]],
        ],
    ],
    16 => [
        'title' => 'Kuis Evaluasi Performa IoT',
        'description' => 'Menilai kemampuan mengukur latency dan throughput sistem IoT',
        'questions' => [
            ['Latency diukur dalam satuan...', ['Milliseconds' => true, 'Bytes' => false, 'Packets' => false, 'Watts' => false]],
            ['Throughput diukur dalam...', ['Data per time unit' => true, 'Voltage' => false, 'Temperature' => false, 'Pressure' => false]],
            ['Latensi rendah penting untuk...', ['Real-time control' => true, 'Batch job' => false, 'Backup' => false, 'Archiving' => false]],
            ['Tool untuk mengukur latency adalah...', ['Wireshark' => true, 'Photoshop' => false, 'Excel' => false, 'Word' => false]],
            ['Throughput tinggi dicapai dengan...', ['Optimasi jaringan' => true, 'Tambah latency' => false, 'Kurang bandwidth' => false, 'Hapus caching' => false]],
        ],
    ],
];
