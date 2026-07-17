<?php

$migrations = glob("database/migrations/*2026_07_17_0145*.php");

$schema = [
    "education_documents" => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->string('elementary_school_name')->nullable();
            \$table->string('elementary_school_path')->nullable();
            \$table->string('junior_high_school_name')->nullable();
            \$table->string('junior_high_school_path')->nullable();
            \$table->string('senior_high_school_name')->nullable();
            \$table->string('senior_high_school_path')->nullable();
            \$table->string('bachelor_university_name')->nullable();
            \$table->string('bachelor_university_path')->nullable();
            \$table->string('masters_university_name')->nullable();
            \$table->string('masters_university_path')->nullable();
            \$table->string('doctoral_university_name')->nullable();
            \$table->string('doctoral_university_path')->nullable();",
    "identity_documents" => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->string('photo_path')->nullable();
            \$table->string('birth_certificate_number')->nullable();
            \$table->string('birth_certificate_path')->nullable();
            \$table->string('family_card_number')->nullable();
            \$table->string('family_card_path')->nullable();
            \$table->string('child_identity_card_number')->nullable();
            \$table->string('child_identity_path')->nullable();
            \$table->string('national_id_number')->nullable();
            \$table->string('national_id_path')->nullable();
            \$table->string('bpjs_number')->nullable();
            \$table->string('bpjs_path')->nullable();
            \$table->string('private_insurance_number')->nullable();
            \$table->string('private_insurance_path')->nullable();
            \$table->string('under_16_integrity_pact_name')->nullable();
            \$table->string('under_16_integrity_pact_path')->nullable();",
    "integrity_documents" => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->date('issue_date')->nullable();
            \$table->enum('integrity_type', ['jawa barat', 'kota/kabupaten', 'keabsahan mutasi'])->nullable();
            \$table->string('integrity_path')->nullable();",
    "user_team_experiences" => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->string('team_name')->nullable();
            \$table->enum('team_type', ['klub', 'pelajar', 'universitas', 'kota/kabupaten', 'provinsi', 'nasional'])->nullable();
            \$table->date('start_date')->nullable();
            \$table->date('end_date')->nullable();",
    "event_experiences" => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->foreignId('club_id')->nullable()->constrained()->nullOnDelete();
            \$table->string('event_role')->nullable();
            \$table->string('court_type')->nullable();
            \$table->string('event_format')->nullable();
            \$table->string('competition_level')->nullable();
            \$table->string('participant_scope')->nullable();
            \$table->string('age_category')->nullable();
            \$table->date('event_start_date')->nullable();
            \$table->date('event_end_date')->nullable();
            \$table->string('result')->nullable();
            \$table->string('event_city')->nullable();
            \$table->string('event_name')->nullable();
            \$table->string('team_name')->nullable();",
    "user_certifications" => "\$table->foreignId('user_id')->constrained()->cascadeOnDelete();
            \$table->enum('certification_type', ['handball', 'professional'])->nullable();
            \$table->string('court_type')->nullable();
            \$table->string('competition_level')->nullable();
            \$table->string('certification_grade')->nullable();
            \$table->string('event_role')->nullable();
            \$table->string('issued_date')->nullable();
            \$table->string('location')->nullable();
            \$table->string('certification_name')->nullable();",
    "club_documents" => "\$table->foreignId('club_id')->constrained()->cascadeOnDelete();
            \$table->string('akta_notaris')->nullable();
            \$table->string('akta_notaris_path')->nullable();
            \$table->date('akta_notaris_date')->nullable();
            \$table->string('badan_hukum')->nullable();
            \$table->string('badan_hukum_path')->nullable();
            \$table->date('badan_hukum_date')->nullable();
            \$table->string('npwp')->nullable();
            \$table->string('npwp_path')->nullable();
            \$table->date('npwp_date')->nullable();
            \$table->string('sk')->nullable();
            \$table->string('sk_path')->nullable();
            \$table->date('sk_date')->nullable();
            \$table->string('ad_art')->nullable();
            \$table->string('ad_art_path')->nullable();
            \$table->date('ad_art_date')->nullable();
            \$table->string('keorganisasian')->nullable();
            \$table->string('keorganisasian_path')->nullable();
            \$table->date('keorganisasian_date')->nullable();
            \$table->string('keolahragaan')->nullable();
            \$table->string('keolahragaan_path')->nullable();
            \$table->date('keolahragaan_date')->nullable();",
    "club_staff" => "\$table->foreignId('club_id')->constrained()->cascadeOnDelete();
            \$table->string('name');
            \$table->string('position');",
    "visi_misis" => "\$table->string('kicker')->nullable();
            \$table->string('title')->nullable();
            \$table->string('mobile_title')->nullable();
            \$table->string('mobile_desc')->nullable();
            \$table->text('visi')->nullable();
            \$table->text('misi')->nullable();
            \$table->string('image')->nullable();",
    "mutation_settings" => "\$table->string('key')->unique();
            \$table->text('value')->nullable();"
];

foreach ($migrations as $file) {
    $content = file_get_contents($file);
    foreach ($schema as $table => $fields) {
        if (strpos($file, $table) !== false) {
            $content = preg_replace('/\$table->id\(\);\s*\$table->timestamps\(\);/', "\$table->id();\n            $fields\n            \$table->timestamps();", $content);
            file_put_contents($file, $content);
            echo "Updated $file\n";
        }
    }
}

