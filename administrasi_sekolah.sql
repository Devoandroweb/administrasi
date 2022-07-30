CREATE SCHEMA administrasi_sekolah;

CREATE  TABLE administrasi_sekolah.administrasi ( 
	id_biaya             INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	id_siswa             INT      ,
	id_jenis_adminitrasi INT      ,
	nominal              BIGINT UNSIGNED     
 ) engine=InnoDB;

CREATE  TABLE administrasi_sekolah.h_transaksi ( 
	id_transaksi         INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	kode                 VARCHAR(150)      ,
	tanggal              DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	id_siswa             INT  NOT NULL    ,
	biaya                TEXT      ,
	tunggakan            TEXT      ,
	created_at           DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	created_by           INT      ,
	updated_at           DATETIME   DEFAULT (NULL)   ,
	updated_by           INT      
 ) engine=InnoDB;

CREATE  TABLE administrasi_sekolah.m_ajaran ( 
	id                   INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	tahun                INT      ,
	`status`             TINYINT      
 ) engine=InnoDB;

CREATE  TABLE administrasi_sekolah.m_jenis_administrasi ( 
	id                   BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nama                 VARCHAR(255)  NOT NULL    ,
	biaya                BIGINT      ,
	deleted              INT  NOT NULL DEFAULT (1)   ,
	created_by           INT  NOT NULL DEFAULT (0)   ,
	updated_by           INT  NOT NULL DEFAULT (0)   ,
	created_at           DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	updated_at           DATETIME   DEFAULT (NULL)   
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE  TABLE administrasi_sekolah.m_jurusan ( 
	id_jurusan           INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nama                 VARCHAR(255)      ,
	created_at           DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	created_by           INT      ,
	updated_at           DATETIME   DEFAULT (NULL)   ,
	updated_by           INT      
 ) engine=InnoDB;

CREATE  TABLE administrasi_sekolah.m_kelas ( 
	id_kelas             INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	nama                 VARCHAR(255)      ,
	id_jurusan           INT      ,
	created_at           DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	created_by           INT      ,
	updated_at           DATETIME   DEFAULT (NULL)   ,
	updated_by           INT      
 ) engine=InnoDB;

CREATE  TABLE administrasi_sekolah.m_siswa ( 
	id_siswa             BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	username             VARCHAR(255)  NOT NULL    ,
	password             TEXT  NOT NULL    ,
	nis                  VARCHAR(255)  NOT NULL    ,
	nama                 VARCHAR(255)  NOT NULL    ,
	tempat_lahir         VARCHAR(20)      ,
	tgl_lahir            DATE      ,
	jk                   INT  NOT NULL    ,
	no_telp              VARCHAR(15)  NOT NULL    ,
	alamat               TEXT  NOT NULL    ,
	foto                 TEXT  NOT NULL    ,
	id_kelas             INT      ,
	deleted              INT  NOT NULL DEFAULT (1)   ,
	created_by           INT  NOT NULL DEFAULT (0)   ,
	updated_by           INT  NOT NULL DEFAULT (0)   ,
	created_at           DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	updated_at           DATETIME      
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE  TABLE administrasi_sekolah.m_whatsapp ( 
	id_whatsapp          INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	pesan                TEXT      ,
	tipe                 TINYINT  NOT NULL    ,
	file                 TEXT      ,
	created_by           INT      ,
	created_at           DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	updated_at           DATETIME   DEFAULT (NULL)   ,
	updated_by           INT      ,
	`status`             TINYINT      
 ) engine=InnoDB;

CREATE  TABLE administrasi_sekolah.tunggakan ( 
	id_tunggakan         INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	id_siswa             INT      ,
	nama_tunggakan       VARCHAR(150)      ,
	nominal              BIGINT UNSIGNED     ,
	ajaran               VARCHAR(4)      
 ) engine=InnoDB;

CREATE  TABLE administrasi_sekolah.users ( 
	id                   BIGINT UNSIGNED NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	name                 VARCHAR(255)  NOT NULL    ,
	email                VARCHAR(255)  NOT NULL    ,
	role                 INT  NOT NULL    ,
	email_verified_at    TIMESTAMP      ,
	password             VARCHAR(255)  NOT NULL    ,
	deleted              INT  NOT NULL DEFAULT (1)   ,
	remember_token       VARCHAR(100)      ,
	created_at           DATETIME   DEFAULT (CURRENT_TIMESTAMP)   ,
	updated_at           DATETIME      
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE  TABLE administrasi_sekolah.whatsapp_send ( 
	id                   INT  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
	id_whatsapp          INT UNSIGNED NOT NULL    ,
	`status`             TINYINT  NOT NULL    
 ) engine=InnoDB;

ALTER TABLE administrasi_sekolah.administrasi COMMENT 'ini juga di sebut biaya siswa';

ALTER TABLE administrasi_sekolah.m_whatsapp MODIFY tipe TINYINT  NOT NULL   COMMENT '1 : Text\n2 : File';

ALTER TABLE administrasi_sekolah.m_whatsapp MODIFY `status` TINYINT     COMMENT '1 : Success\n2 : Failed';

ALTER TABLE administrasi_sekolah.tunggakan MODIFY ajaran VARCHAR(4)     COMMENT 'untuk tahun ajaran';

ALTER TABLE administrasi_sekolah.users MODIFY role INT  NOT NULL   COMMENT '1 : Admin\n2 : Bendahara\n3 :  Kepala Sekolah';

ALTER TABLE administrasi_sekolah.whatsapp_send MODIFY `status` TINYINT  NOT NULL   COMMENT '1 : Sukses\n2 : Gagal';
