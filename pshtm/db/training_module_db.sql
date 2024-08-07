toc.dat                                                                                             0000600 0004000 0002000 00000127246 14572041001 0014445 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        PGDMP       ,                |            training_module_db    16.1    16.1 z    |           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false         }           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false         ~           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                    1262    25100    training_module_db    DATABASE     �   CREATE DATABASE training_module_db WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
 "   DROP DATABASE training_module_db;
                postgres    false         �            1259    25101    admin_records    TABLE     �   CREATE TABLE public.admin_records (
    admin_id bigint NOT NULL,
    first_name character varying(250),
    last_name character varying(250),
    mobile character varying(10),
    email character varying(150)
);
 !   DROP TABLE public.admin_records;
       public         heap    postgres    false         �            1259    25106    create_training_programs    TABLE     �   CREATE TABLE public.create_training_programs (
    training_program_id bigint NOT NULL,
    name character varying(150),
    training_desc character varying(500),
    training_status boolean
);
 ,   DROP TABLE public.create_training_programs;
       public         heap    postgres    false         �            1259    25111    training_reports    TABLE     �   CREATE TABLE public.training_reports (
    id integer NOT NULL,
    training_program_id bigint NOT NULL,
    start_date date,
    end_date date,
    attendance integer,
    participation integer,
    completion_rate double precision
);
 $   DROP TABLE public.training_reports;
       public         heap    postgres    false         �            1259    25114    date_summary_reports    VIEW     k  CREATE VIEW public.date_summary_reports AS
 SELECT ctp.training_program_id,
    ctp.name AS training_program_name,
    tr.start_date,
    tr.end_date
   FROM (public.create_training_programs ctp
     JOIN public.training_reports tr ON ((ctp.training_program_id = tr.training_program_id)))
  GROUP BY ctp.training_program_id, ctp.name, tr.start_date, tr.end_date;
 '   DROP VIEW public.date_summary_reports;
       public          postgres    false    217    216    217    216    217         �            1259    25118 
   department    TABLE     r   CREATE TABLE public.department (
    department_id bigint NOT NULL,
    department_name character varying(150)
);
    DROP TABLE public.department;
       public         heap    postgres    false         �            1259    25121    training_relations    TABLE     �   CREATE TABLE public.training_relations (
    id integer NOT NULL,
    training_program_id bigint,
    job_post_id bigint,
    department_id bigint
);
 &   DROP TABLE public.training_relations;
       public         heap    postgres    false         �            1259    25124    department_summary_reports    VIEW     |  CREATE VIEW public.department_summary_reports AS
 SELECT tr.training_program_id,
    ctp.name AS training_program_name,
    tr.department_id,
    d.department_name
   FROM ((public.create_training_programs ctp
     JOIN public.training_relations tr ON ((ctp.training_program_id = tr.training_program_id)))
     JOIN public.department d ON ((tr.department_id = d.department_id)));
 -   DROP VIEW public.department_summary_reports;
       public          postgres    false    220    219    219    216    216    220         �            1259    25128    emp_training_relation    TABLE     s   CREATE TABLE public.emp_training_relation (
    emp_id bigint NOT NULL,
    training_program_id bigint NOT NULL
);
 )   DROP TABLE public.emp_training_relation;
       public         heap    postgres    false         �            1259    25131    employee_records    TABLE     W  CREATE TABLE public.employee_records (
    emp_id integer NOT NULL,
    emp_first_name character varying(150),
    emp_last_name character varying(150),
    emp_mobile character varying(10),
    emp_email character varying(250),
    emp_image character varying(500),
    emp_status boolean,
    job_post_id bigint,
    department_id bigint
);
 $   DROP TABLE public.employee_records;
       public         heap    postgres    false         �            1259    25136    employee_records_emp_id_seq    SEQUENCE     �   CREATE SEQUENCE public.employee_records_emp_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.employee_records_emp_id_seq;
       public          postgres    false    223         �           0    0    employee_records_emp_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.employee_records_emp_id_seq OWNED BY public.employee_records.emp_id;
          public          postgres    false    224         �            1259    25137    employee_reports    TABLE     �   CREATE TABLE public.employee_reports (
    emp_id bigint NOT NULL,
    training_program_id bigint NOT NULL,
    employee_performance double precision,
    questionnaire1_result double precision,
    questionnaire2_result double precision
);
 $   DROP TABLE public.employee_reports;
       public         heap    postgres    false         �            1259    25140    employee_summary_reports    VIEW     )  CREATE VIEW public.employee_summary_reports AS
 SELECT e.emp_id,
    e.emp_first_name,
    e.emp_last_name,
    er.training_program_id,
    er.questionnaire1_result,
    er.questionnaire2_result
   FROM (public.employee_records e
     JOIN public.employee_reports er ON ((e.emp_id = er.emp_id)));
 +   DROP VIEW public.employee_summary_reports;
       public          postgres    false    225    225    225    225    223    223    223         �            1259    25144    job_post    TABLE     m   CREATE TABLE public.job_post (
    job_post_id integer NOT NULL,
    job_post_name character varying(250)
);
    DROP TABLE public.job_post;
       public         heap    postgres    false         �            1259    25147    job_post_job_post_id_seq    SEQUENCE     �   CREATE SEQUENCE public.job_post_job_post_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.job_post_job_post_id_seq;
       public          postgres    false    227         �           0    0    job_post_job_post_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.job_post_job_post_id_seq OWNED BY public.job_post.job_post_id;
          public          postgres    false    228         �            1259    25148    login_credentials_admin    TABLE     �   CREATE TABLE public.login_credentials_admin (
    admin_id bigint NOT NULL,
    username character varying(30) NOT NULL,
    password character varying(20),
    status boolean
);
 +   DROP TABLE public.login_credentials_admin;
       public         heap    postgres    false         �            1259    25151    login_credentials_trainers    TABLE     �   CREATE TABLE public.login_credentials_trainers (
    trainer_id bigint NOT NULL,
    username character varying(20) NOT NULL,
    password character varying(15),
    status boolean
);
 .   DROP TABLE public.login_credentials_trainers;
       public         heap    postgres    false         �            1259    25154    mcq_options    TABLE     �   CREATE TABLE public.mcq_options (
    ques_id bigint NOT NULL,
    option_1 character varying(100),
    option_2 character varying(100),
    option_3 character varying(100),
    option_4 character varying(100)
);
    DROP TABLE public.mcq_options;
       public         heap    postgres    false         �            1259    25157    month_summary_reports    VIEW     �  CREATE VIEW public.month_summary_reports AS
 SELECT ctp.training_program_id,
    ctp.name AS training_program_name,
    EXTRACT(year FROM tr.start_date) AS year,
    EXTRACT(month FROM tr.start_date) AS month,
    count(*) AS program_count
   FROM (public.create_training_programs ctp
     JOIN public.training_reports tr ON ((ctp.training_program_id = tr.training_program_id)))
  GROUP BY ctp.training_program_id, ctp.name, (EXTRACT(year FROM tr.start_date)), (EXTRACT(month FROM tr.start_date));
 (   DROP VIEW public.month_summary_reports;
       public          postgres    false    216    216    217    217         �            1259    25162    post_student_ans    TABLE     �   CREATE TABLE public.post_student_ans (
    id integer NOT NULL,
    ques_id bigint NOT NULL,
    emp_id bigint,
    post_student_ans character varying(3000)
);
 $   DROP TABLE public.post_student_ans;
       public         heap    postgres    false         �            1259    25167    post_student_ans_id_seq    SEQUENCE     �   CREATE SEQUENCE public.post_student_ans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.post_student_ans_id_seq;
       public          postgres    false    233         �           0    0    post_student_ans_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.post_student_ans_id_seq OWNED BY public.post_student_ans.id;
          public          postgres    false    234         �            1259    25168    pre_post_result    TABLE     �   CREATE TABLE public.pre_post_result (
    training_program_id bigint NOT NULL,
    pre_result double precision,
    post_result double precision
);
 #   DROP TABLE public.pre_post_result;
       public         heap    postgres    false         �            1259    25171    pre_student_ans    TABLE     �   CREATE TABLE public.pre_student_ans (
    id integer NOT NULL,
    ques_id bigint NOT NULL,
    emp_id bigint,
    pre_student_ans character varying(3000)
);
 #   DROP TABLE public.pre_student_ans;
       public         heap    postgres    false         �            1259    25176    pre_student_ans_id_seq    SEQUENCE     �   CREATE SEQUENCE public.pre_student_ans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.pre_student_ans_id_seq;
       public          postgres    false    236         �           0    0    pre_student_ans_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.pre_student_ans_id_seq OWNED BY public.pre_student_ans.id;
          public          postgres    false    237         �            1259    25177 	   questions    TABLE     �   CREATE TABLE public.questions (
    ques_id integer NOT NULL,
    que_text character varying(2000),
    training_program_id bigint,
    ques_type character varying
);
    DROP TABLE public.questions;
       public         heap    postgres    false         �            1259    25182    question_details    VIEW       CREATE VIEW public.question_details AS
 SELECT q.ques_id,
    q.que_text,
    q.training_program_id,
    q.ques_type,
    mo.option_1,
    mo.option_2,
    mo.option_3,
    mo.option_4
   FROM (public.questions q
     LEFT JOIN public.mcq_options mo ON ((q.ques_id = mo.ques_id)));
 #   DROP VIEW public.question_details;
       public          postgres    false    231    231    231    238    238    238    238    231    231         �            1259    25186    questions_ques_id_seq    SEQUENCE     �   CREATE SEQUENCE public.questions_ques_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.questions_ques_id_seq;
       public          postgres    false    238         �           0    0    questions_ques_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.questions_ques_id_seq OWNED BY public.questions.ques_id;
          public          postgres    false    240         �            1259    25187    trainer_records    TABLE     �   CREATE TABLE public.trainer_records (
    trainer_id bigint NOT NULL,
    first_name character varying(250),
    last_name character varying(250),
    mobile character varying(10),
    email character varying(150)
);
 #   DROP TABLE public.trainer_records;
       public         heap    postgres    false         �            1259    25192    training_trainer_relation    TABLE     {   CREATE TABLE public.training_trainer_relation (
    training_program_id bigint NOT NULL,
    trainer_id bigint NOT NULL
);
 -   DROP TABLE public.training_trainer_relation;
       public         heap    postgres    false         �            1259    25195    trainer_summary_reports    VIEW     �  CREATE VIEW public.trainer_summary_reports AS
 SELECT t.trainer_id,
    concat(t.first_name, ' ', t.last_name) AS trainer_name,
    ctp.training_program_id,
    ctp.name AS training_program_name
   FROM ((public.trainer_records t
     LEFT JOIN public.training_trainer_relation rel ON ((t.trainer_id = rel.trainer_id)))
     LEFT JOIN public.create_training_programs ctp ON ((rel.training_program_id = ctp.training_program_id)));
 *   DROP VIEW public.trainer_summary_reports;
       public          postgres    false    241    241    216    241    242    242    216         �            1259    25199    training_images    TABLE     �   CREATE TABLE public.training_images (
    id integer NOT NULL,
    training_program_id bigint NOT NULL,
    image character varying(300)
);
 #   DROP TABLE public.training_images;
       public         heap    postgres    false         �            1259    25202    training_images_id_seq    SEQUENCE     �   CREATE SEQUENCE public.training_images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.training_images_id_seq;
       public          postgres    false    244         �           0    0    training_images_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.training_images_id_seq OWNED BY public.training_images.id;
          public          postgres    false    245         �            1259    25203    training_relations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.training_relations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.training_relations_id_seq;
       public          postgres    false    220         �           0    0    training_relations_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.training_relations_id_seq OWNED BY public.training_relations.id;
          public          postgres    false    246         �            1259    25204    training_reports_id_seq    SEQUENCE     �   CREATE SEQUENCE public.training_reports_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.training_reports_id_seq;
       public          postgres    false    217         �           0    0    training_reports_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.training_reports_id_seq OWNED BY public.training_reports.id;
          public          postgres    false    247         �            1259    25205    training_summary_reports    VIEW     �  CREATE VIEW public.training_summary_reports AS
 SELECT t.training_program_id,
    t.name AS training_program_name,
    tr.start_date,
    tr.end_date,
    tr.attendance,
    tr.participation,
    t.training_status AS status,
    tr.completion_rate,
    ppr.pre_result,
    ppr.post_result,
    jp.job_post_name,
    d.department_name,
    ti.image AS training_image,
    t.training_desc,
    tt.trainer_id,
    trr.first_name AS trainer_first_name
   FROM ((((((((public.create_training_programs t
     JOIN public.training_reports tr ON ((t.training_program_id = tr.training_program_id)))
     JOIN public.pre_post_result ppr ON ((t.training_program_id = ppr.training_program_id)))
     JOIN public.training_relations trl ON ((t.training_program_id = trl.training_program_id)))
     JOIN public.job_post jp ON ((trl.job_post_id = jp.job_post_id)))
     JOIN public.department d ON ((trl.department_id = d.department_id)))
     JOIN public.training_images ti ON ((t.training_program_id = ti.training_program_id)))
     JOIN public.training_trainer_relation tt ON ((t.training_program_id = tt.training_program_id)))
     JOIN public.trainer_records trr ON ((tt.trainer_id = trr.trainer_id)));
 +   DROP VIEW public.training_summary_reports;
       public          postgres    false    217    244    242    242    241    241    235    235    235    227    227    220    220    220    219    219    217    217    217    217    217    216    216    216    216    244         �           2604    25210    employee_records emp_id    DEFAULT     �   ALTER TABLE ONLY public.employee_records ALTER COLUMN emp_id SET DEFAULT nextval('public.employee_records_emp_id_seq'::regclass);
 F   ALTER TABLE public.employee_records ALTER COLUMN emp_id DROP DEFAULT;
       public          postgres    false    224    223         �           2604    25211    job_post job_post_id    DEFAULT     |   ALTER TABLE ONLY public.job_post ALTER COLUMN job_post_id SET DEFAULT nextval('public.job_post_job_post_id_seq'::regclass);
 C   ALTER TABLE public.job_post ALTER COLUMN job_post_id DROP DEFAULT;
       public          postgres    false    228    227         �           2604    25212    post_student_ans id    DEFAULT     z   ALTER TABLE ONLY public.post_student_ans ALTER COLUMN id SET DEFAULT nextval('public.post_student_ans_id_seq'::regclass);
 B   ALTER TABLE public.post_student_ans ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    234    233         �           2604    25213    pre_student_ans id    DEFAULT     x   ALTER TABLE ONLY public.pre_student_ans ALTER COLUMN id SET DEFAULT nextval('public.pre_student_ans_id_seq'::regclass);
 A   ALTER TABLE public.pre_student_ans ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    237    236         �           2604    25214    questions ques_id    DEFAULT     v   ALTER TABLE ONLY public.questions ALTER COLUMN ques_id SET DEFAULT nextval('public.questions_ques_id_seq'::regclass);
 @   ALTER TABLE public.questions ALTER COLUMN ques_id DROP DEFAULT;
       public          postgres    false    240    238         �           2604    25215    training_images id    DEFAULT     x   ALTER TABLE ONLY public.training_images ALTER COLUMN id SET DEFAULT nextval('public.training_images_id_seq'::regclass);
 A   ALTER TABLE public.training_images ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    245    244         �           2604    25216    training_relations id    DEFAULT     ~   ALTER TABLE ONLY public.training_relations ALTER COLUMN id SET DEFAULT nextval('public.training_relations_id_seq'::regclass);
 D   ALTER TABLE public.training_relations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    246    220         �           2604    25217    training_reports id    DEFAULT     z   ALTER TABLE ONLY public.training_reports ALTER COLUMN id SET DEFAULT nextval('public.training_reports_id_seq'::regclass);
 B   ALTER TABLE public.training_reports ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    247    217         _          0    25101    admin_records 
   TABLE DATA           W   COPY public.admin_records (admin_id, first_name, last_name, mobile, email) FROM stdin;
    public          postgres    false    215       4959.dat `          0    25106    create_training_programs 
   TABLE DATA           m   COPY public.create_training_programs (training_program_id, name, training_desc, training_status) FROM stdin;
    public          postgres    false    216       4960.dat b          0    25118 
   department 
   TABLE DATA           D   COPY public.department (department_id, department_name) FROM stdin;
    public          postgres    false    219       4962.dat d          0    25128    emp_training_relation 
   TABLE DATA           L   COPY public.emp_training_relation (emp_id, training_program_id) FROM stdin;
    public          postgres    false    222       4964.dat e          0    25131    employee_records 
   TABLE DATA           �   COPY public.employee_records (emp_id, emp_first_name, emp_last_name, emp_mobile, emp_email, emp_image, emp_status, job_post_id, department_id) FROM stdin;
    public          postgres    false    223       4965.dat g          0    25137    employee_reports 
   TABLE DATA           �   COPY public.employee_reports (emp_id, training_program_id, employee_performance, questionnaire1_result, questionnaire2_result) FROM stdin;
    public          postgres    false    225       4967.dat h          0    25144    job_post 
   TABLE DATA           >   COPY public.job_post (job_post_id, job_post_name) FROM stdin;
    public          postgres    false    227       4968.dat j          0    25148    login_credentials_admin 
   TABLE DATA           W   COPY public.login_credentials_admin (admin_id, username, password, status) FROM stdin;
    public          postgres    false    229       4970.dat k          0    25151    login_credentials_trainers 
   TABLE DATA           \   COPY public.login_credentials_trainers (trainer_id, username, password, status) FROM stdin;
    public          postgres    false    230       4971.dat l          0    25154    mcq_options 
   TABLE DATA           V   COPY public.mcq_options (ques_id, option_1, option_2, option_3, option_4) FROM stdin;
    public          postgres    false    231       4972.dat m          0    25162    post_student_ans 
   TABLE DATA           Q   COPY public.post_student_ans (id, ques_id, emp_id, post_student_ans) FROM stdin;
    public          postgres    false    233       4973.dat o          0    25168    pre_post_result 
   TABLE DATA           W   COPY public.pre_post_result (training_program_id, pre_result, post_result) FROM stdin;
    public          postgres    false    235       4975.dat p          0    25171    pre_student_ans 
   TABLE DATA           O   COPY public.pre_student_ans (id, ques_id, emp_id, pre_student_ans) FROM stdin;
    public          postgres    false    236       4976.dat r          0    25177 	   questions 
   TABLE DATA           V   COPY public.questions (ques_id, que_text, training_program_id, ques_type) FROM stdin;
    public          postgres    false    238       4978.dat t          0    25187    trainer_records 
   TABLE DATA           [   COPY public.trainer_records (trainer_id, first_name, last_name, mobile, email) FROM stdin;
    public          postgres    false    241       4980.dat v          0    25199    training_images 
   TABLE DATA           I   COPY public.training_images (id, training_program_id, image) FROM stdin;
    public          postgres    false    244       4982.dat c          0    25121    training_relations 
   TABLE DATA           a   COPY public.training_relations (id, training_program_id, job_post_id, department_id) FROM stdin;
    public          postgres    false    220       4963.dat a          0    25111    training_reports 
   TABLE DATA           �   COPY public.training_reports (id, training_program_id, start_date, end_date, attendance, participation, completion_rate) FROM stdin;
    public          postgres    false    217       4961.dat u          0    25192    training_trainer_relation 
   TABLE DATA           T   COPY public.training_trainer_relation (training_program_id, trainer_id) FROM stdin;
    public          postgres    false    242       4981.dat �           0    0    employee_records_emp_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.employee_records_emp_id_seq', 32, true);
          public          postgres    false    224         �           0    0    job_post_job_post_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.job_post_job_post_id_seq', 23, true);
          public          postgres    false    228         �           0    0    post_student_ans_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.post_student_ans_id_seq', 20, true);
          public          postgres    false    234         �           0    0    pre_student_ans_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.pre_student_ans_id_seq', 20, true);
          public          postgres    false    237         �           0    0    questions_ques_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.questions_ques_id_seq', 30, true);
          public          postgres    false    240         �           0    0    training_images_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.training_images_id_seq', 8, true);
          public          postgres    false    245         �           0    0    training_relations_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.training_relations_id_seq', 37, true);
          public          postgres    false    246         �           0    0    training_reports_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.training_reports_id_seq', 16, true);
          public          postgres    false    247         �           2606    25219     admin_records admin_records_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.admin_records
    ADD CONSTRAINT admin_records_pkey PRIMARY KEY (admin_id);
 J   ALTER TABLE ONLY public.admin_records DROP CONSTRAINT admin_records_pkey;
       public            postgres    false    215         �           2606    25221 6   create_training_programs create_training_programs_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.create_training_programs
    ADD CONSTRAINT create_training_programs_pkey PRIMARY KEY (training_program_id);
 `   ALTER TABLE ONLY public.create_training_programs DROP CONSTRAINT create_training_programs_pkey;
       public            postgres    false    216         �           2606    25223    department department_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY public.department
    ADD CONSTRAINT department_pkey PRIMARY KEY (department_id);
 D   ALTER TABLE ONLY public.department DROP CONSTRAINT department_pkey;
       public            postgres    false    219         �           2606    25225 0   emp_training_relation emp_training_relation_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT emp_training_relation_pkey PRIMARY KEY (emp_id, training_program_id);
 Z   ALTER TABLE ONLY public.emp_training_relation DROP CONSTRAINT emp_training_relation_pkey;
       public            postgres    false    222    222         �           2606    25227 &   employee_records employee_records_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT employee_records_pkey PRIMARY KEY (emp_id);
 P   ALTER TABLE ONLY public.employee_records DROP CONSTRAINT employee_records_pkey;
       public            postgres    false    223         �           2606    25229 &   employee_reports employee_reports_pkey 
   CONSTRAINT     }   ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT employee_reports_pkey PRIMARY KEY (emp_id, training_program_id);
 P   ALTER TABLE ONLY public.employee_reports DROP CONSTRAINT employee_reports_pkey;
       public            postgres    false    225    225         �           2606    25231    job_post job_post_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.job_post
    ADD CONSTRAINT job_post_pkey PRIMARY KEY (job_post_id);
 @   ALTER TABLE ONLY public.job_post DROP CONSTRAINT job_post_pkey;
       public            postgres    false    227         �           2606    25233 4   login_credentials_admin login_credentials_admin_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_admin
    ADD CONSTRAINT login_credentials_admin_pkey PRIMARY KEY (admin_id, username);
 ^   ALTER TABLE ONLY public.login_credentials_admin DROP CONSTRAINT login_credentials_admin_pkey;
       public            postgres    false    229    229         �           2606    25235 :   login_credentials_trainers login_credentials_trainers_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_trainers
    ADD CONSTRAINT login_credentials_trainers_pkey PRIMARY KEY (trainer_id, username);
 d   ALTER TABLE ONLY public.login_credentials_trainers DROP CONSTRAINT login_credentials_trainers_pkey;
       public            postgres    false    230    230         �           2606    25237    mcq_options mcq_options_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.mcq_options
    ADD CONSTRAINT mcq_options_pkey PRIMARY KEY (ques_id);
 F   ALTER TABLE ONLY public.mcq_options DROP CONSTRAINT mcq_options_pkey;
       public            postgres    false    231         �           2606    25239 &   post_student_ans post_student_ans_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT post_student_ans_pkey PRIMARY KEY (id, ques_id);
 P   ALTER TABLE ONLY public.post_student_ans DROP CONSTRAINT post_student_ans_pkey;
       public            postgres    false    233    233         �           2606    25241 $   pre_post_result pre_post_result_pkey 
   CONSTRAINT     s   ALTER TABLE ONLY public.pre_post_result
    ADD CONSTRAINT pre_post_result_pkey PRIMARY KEY (training_program_id);
 N   ALTER TABLE ONLY public.pre_post_result DROP CONSTRAINT pre_post_result_pkey;
       public            postgres    false    235         �           2606    25243 $   pre_student_ans pre_student_ans_pkey 
   CONSTRAINT     k   ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT pre_student_ans_pkey PRIMARY KEY (id, ques_id);
 N   ALTER TABLE ONLY public.pre_student_ans DROP CONSTRAINT pre_student_ans_pkey;
       public            postgres    false    236    236         �           2606    25245    questions questions_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (ques_id);
 B   ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_pkey;
       public            postgres    false    238         �           2606    25247 $   trainer_records trainer_records_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY public.trainer_records
    ADD CONSTRAINT trainer_records_pkey PRIMARY KEY (trainer_id);
 N   ALTER TABLE ONLY public.trainer_records DROP CONSTRAINT trainer_records_pkey;
       public            postgres    false    241         �           2606    25249 $   training_images training_images_pkey 
   CONSTRAINT     w   ALTER TABLE ONLY public.training_images
    ADD CONSTRAINT training_images_pkey PRIMARY KEY (id, training_program_id);
 N   ALTER TABLE ONLY public.training_images DROP CONSTRAINT training_images_pkey;
       public            postgres    false    244    244         �           2606    25251 *   training_relations training_relations_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT training_relations_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT training_relations_pkey;
       public            postgres    false    220         �           2606    25253 &   training_reports training_reports_pkey 
   CONSTRAINT     y   ALTER TABLE ONLY public.training_reports
    ADD CONSTRAINT training_reports_pkey PRIMARY KEY (id, training_program_id);
 P   ALTER TABLE ONLY public.training_reports DROP CONSTRAINT training_reports_pkey;
       public            postgres    false    217    217         �           2606    25255 8   training_trainer_relation training_trainer_relation_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT training_trainer_relation_pkey PRIMARY KEY (training_program_id, trainer_id);
 b   ALTER TABLE ONLY public.training_trainer_relation DROP CONSTRAINT training_trainer_relation_pkey;
       public            postgres    false    242    242         �           2606    25256 5   emp_training_relation FK_emp_training_relation.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT "FK_emp_training_relation.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id) ON UPDATE CASCADE ON DELETE CASCADE;
 a   ALTER TABLE ONLY public.emp_training_relation DROP CONSTRAINT "FK_emp_training_relation.emp_id";
       public          postgres    false    4762    222    223         �           2606    25261 B   emp_training_relation FK_emp_training_relation.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT "FK_emp_training_relation.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 n   ALTER TABLE ONLY public.emp_training_relation DROP CONSTRAINT "FK_emp_training_relation.training_program_id";
       public          postgres    false    222    4752    216         �           2606    25266 +   employee_reports FK_employee_reports.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT "FK_employee_reports.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id) ON UPDATE CASCADE ON DELETE CASCADE;
 W   ALTER TABLE ONLY public.employee_reports DROP CONSTRAINT "FK_employee_reports.emp_id";
       public          postgres    false    4762    223    225         �           2606    25271 8   employee_reports FK_employee_reports.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT "FK_employee_reports.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 d   ALTER TABLE ONLY public.employee_reports DROP CONSTRAINT "FK_employee_reports.training_program_id";
       public          postgres    false    4752    225    216         �           2606    25276 ;   login_credentials_admin FK_login_credentials_admin.admin_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_admin
    ADD CONSTRAINT "FK_login_credentials_admin.admin_id" FOREIGN KEY (admin_id) REFERENCES public.admin_records(admin_id) ON UPDATE CASCADE ON DELETE CASCADE;
 g   ALTER TABLE ONLY public.login_credentials_admin DROP CONSTRAINT "FK_login_credentials_admin.admin_id";
       public          postgres    false    4750    215    229         �           2606    25281 C   login_credentials_trainers FK_login_credentials_trainers.trainer_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_trainers
    ADD CONSTRAINT "FK_login_credentials_trainers.trainer_id" FOREIGN KEY (trainer_id) REFERENCES public.trainer_records(trainer_id) ON UPDATE CASCADE ON DELETE CASCADE;
 o   ALTER TABLE ONLY public.login_credentials_trainers DROP CONSTRAINT "FK_login_credentials_trainers.trainer_id";
       public          postgres    false    230    241    4782         �           2606    25286 "   mcq_options FK_mcq_options.ques_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.mcq_options
    ADD CONSTRAINT "FK_mcq_options.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id) ON UPDATE CASCADE ON DELETE CASCADE;
 N   ALTER TABLE ONLY public.mcq_options DROP CONSTRAINT "FK_mcq_options.ques_id";
       public          postgres    false    4780    238    231         �           2606    25291 +   post_student_ans FK_post_student_ans.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT "FK_post_student_ans.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id);
 W   ALTER TABLE ONLY public.post_student_ans DROP CONSTRAINT "FK_post_student_ans.emp_id";
       public          postgres    false    223    233    4762         �           2606    25296 ,   post_student_ans FK_post_student_ans.ques_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT "FK_post_student_ans.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id);
 X   ALTER TABLE ONLY public.post_student_ans DROP CONSTRAINT "FK_post_student_ans.ques_id";
       public          postgres    false    238    233    4780         �           2606    25301 6   pre_post_result FK_pre_post_result.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.pre_post_result
    ADD CONSTRAINT "FK_pre_post_result.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.pre_post_result DROP CONSTRAINT "FK_pre_post_result.training_program_id";
       public          postgres    false    235    4752    216         �           2606    25306 )   pre_student_ans FK_pre_student_ans.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT "FK_pre_student_ans.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id);
 U   ALTER TABLE ONLY public.pre_student_ans DROP CONSTRAINT "FK_pre_student_ans.emp_id";
       public          postgres    false    4762    223    236         �           2606    25311 *   pre_student_ans FK_pre_student_ans.ques_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT "FK_pre_student_ans.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id);
 V   ALTER TABLE ONLY public.pre_student_ans DROP CONSTRAINT "FK_pre_student_ans.ques_id";
       public          postgres    false    238    236    4780         �           2606    25316 *   questions FK_questions.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT "FK_questions.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 V   ALTER TABLE ONLY public.questions DROP CONSTRAINT "FK_questions.training_program_id";
       public          postgres    false    216    238    4752         �           2606    25321 6   training_images FK_training_images.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_images
    ADD CONSTRAINT "FK_training_images.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.training_images DROP CONSTRAINT "FK_training_images.training_program_id";
       public          postgres    false    4752    216    244         �           2606    25326 6   training_relations FK_training_relations.department_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.department_id" FOREIGN KEY (department_id) REFERENCES public.department(department_id) ON UPDATE CASCADE ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT "FK_training_relations.department_id";
       public          postgres    false    220    219    4756         �           2606    25331 4   training_relations FK_training_relations.job_post_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.job_post_id" FOREIGN KEY (job_post_id) REFERENCES public.job_post(job_post_id) ON UPDATE CASCADE ON DELETE CASCADE;
 `   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT "FK_training_relations.job_post_id";
       public          postgres    false    227    4766    220         �           2606    25336 <   training_relations FK_training_relations.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 h   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT "FK_training_relations.training_program_id";
       public          postgres    false    4752    220    216         �           2606    25341 8   training_reports FK_training_reports.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_reports
    ADD CONSTRAINT "FK_training_reports.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 d   ALTER TABLE ONLY public.training_reports DROP CONSTRAINT "FK_training_reports.training_program_id";
       public          postgres    false    216    217    4752         �           2606    25346 A   training_trainer_relation FK_training_trainer_relation.trainer_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT "FK_training_trainer_relation.trainer_id" FOREIGN KEY (trainer_id) REFERENCES public.trainer_records(trainer_id) ON UPDATE CASCADE ON DELETE CASCADE;
 m   ALTER TABLE ONLY public.training_trainer_relation DROP CONSTRAINT "FK_training_trainer_relation.trainer_id";
       public          postgres    false    242    241    4782         �           2606    25351 J   training_trainer_relation FK_training_trainer_relation.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT "FK_training_trainer_relation.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 v   ALTER TABLE ONLY public.training_trainer_relation DROP CONSTRAINT "FK_training_trainer_relation.training_program_id";
       public          postgres    false    242    4752    216         �           2606    25418 ,   employee_records fk_constraint_department_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT fk_constraint_department_id FOREIGN KEY (department_id) REFERENCES public.department(department_id) ON UPDATE CASCADE ON DELETE CASCADE;
 V   ALTER TABLE ONLY public.employee_records DROP CONSTRAINT fk_constraint_department_id;
       public          postgres    false    223    219    4756         �           2606    25413 '   employee_records fk_constraint_job_post    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT fk_constraint_job_post FOREIGN KEY (job_post_id) REFERENCES public.job_post(job_post_id) ON UPDATE CASCADE ON DELETE CASCADE;
 Q   ALTER TABLE ONLY public.employee_records DROP CONSTRAINT fk_constraint_job_post;
       public          postgres    false    223    227    4766                                                                                                                                                                                                                                                                                                                                                                  4959.dat                                                                                            0000600 0004000 0002000 00000000212 14572041001 0014251 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        1	John	Doe	1112223334	john.doe@hospital.com
2	Jane	Smith	5556667778	jane.smith@hospital.com
101	admin	one	0000000000	admin@gmail.com
\.


                                                                                                                                                                                                                                                                                                                                                                                      4960.dat                                                                                            0000600 0004000 0002000 00000000252 14572041001 0014245 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        108	emergency	its an emergency signal i repeat code red 	t
911	stock center	a aeroplane crash in a stock exchange building  911	t
0	xyz	abcdefghijklmnopqrstuvwxyz	t
\.


                                                                                                                                                                                                                                                                                                                                                      4962.dat                                                                                            0000600 0004000 0002000 00000000071 14572041001 0014246 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        1	Cardiology
3	Surgery
2	emergency med
5	departure 
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                                                       4964.dat                                                                                            0000600 0004000 0002000 00000000030 14572041001 0014243 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        30	911
30	108
32	0
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        4965.dat                                                                                            0000600 0004000 0002000 00000000254 14572041001 0014254 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        30	abc	def	1111111111	ok@gmail.com	profile1.png	t	19	3
31	lmno	pqr	0000000000	xyz@gmail.com	profile2.png	t	23	2
32	Neha	m	9620201903	xyz@gmail.com	profile3.png	t	16	1
\.


                                                                                                                                                                                                                                                                                                                                                    4967.dat                                                                                            0000600 0004000 0002000 00000000064 14572041001 0014255 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        30	911	50	20	30
30	108	80	50	80
32	0	90	80	100
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                                                            4968.dat                                                                                            0000600 0004000 0002000 00000000223 14572041001 0014253 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        15	Cardiologist
16	General Surgeon
17	Registered Nurse
18	Nurse Practitioner
19	Lab Technician
20	Radiologist
21	Anesthesiologist
23	jobohyes
\.


                                                                                                                                                                                                                                                                                                                                                                             4970.dat                                                                                            0000600 0004000 0002000 00000000101 14572041001 0014237 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        2	Jane	password456	f
1	John	password123	f
101	admin	admin	t
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                                               4971.dat                                                                                            0000600 0004000 0002000 00000000224 14572041001 0014246 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        2	bwilliams	password456	f
3	smiller	password789	f
4	dbrown	password012	f
5	ejones	password345	f
1	ajohnson	password123	f
202	trainer	trainer	f
\.


                                                                                                                                                                                                                                                                                                                                                                            4972.dat                                                                                            0000600 0004000 0002000 00000000073 14572041001 0014251 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        15	govt	terror	incedent	fbi
24	10	20	30	40
28	a	b	c	d
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                                                     4973.dat                                                                                            0000600 0004000 0002000 00000000320 14572041001 0014245 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        8	15	30	govt
9	16	30	the same as above
10	17	30	1000000
11	18	30	it was me
12	21	30	exit
13	22	30	10
14	23	30	exit
15	21	31	yes
16	22	31	50
17	23	31	live
18	28	32	a
19	29	32	rgb color
20	30	32	xuv light
\.


                                                                                                                                                                                                                                                                                                                4975.dat                                                                                            0000600 0004000 0002000 00000000005 14572041001 0014247 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        \.


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           4976.dat                                                                                            0000600 0004000 0002000 00000000341 14572041001 0014253 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        8	15	30	govt
9	16	30	the plane lose control and crash straight into building
10	17	30	1000000
11	18	30	me
12	21	30	yes
13	22	30	5
14	23	30	live
15	21	31	yes
16	22	31	50
17	23	31	live
18	28	32	a
19	29	32	rgb
20	30	32	xuv
\.


                                                                                                                                                                                                                                                                                               4978.dat                                                                                            0000600 0004000 0002000 00000000507 14572041001 0014261 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        15	who was behind it	911	mcq
16	describe the incident	911	textarea
17	enter the figure of loss faced	911	number
18	cause or reason behind it	911	text
21	emergency exit	108	text
22	how many emergency exit	108	number
23	why exit	108	textarea
24	how many people died	911	mcq
28	xyz	0	mcq
29	abcd	0	text
30	abcdefg	0	textarea
\.


                                                                                                                                                                                         4980.dat                                                                                            0000600 0004000 0002000 00000000454 14572041001 0014253 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        1	Alice	Johnson	1234567890	alice.johnson@hospital.com
2	Bob	Williams	9876543210	bob.williams@hospital.com
3	Sarah	Miller	5554443332	sarah.miller@hospital.com
4	David	Brown	2223334445	david.brown@hospital.com
5	Emily	Jones	8887776661	emily.jones@hospital.com
202	train	er	1111111111	tr@gmail.com
\.


                                                                                                                                                                                                                    4982.dat                                                                                            0000600 0004000 0002000 00000000126 14572041001 0014251 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        4	911	bricks.jpg
5	108	classroom-2093744_1280.jpg
8	0	classroom-2093744_1280.jpg
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                          4963.dat                                                                                            0000600 0004000 0002000 00000000121 14572041001 0014243 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        29	108	19	3
30	108	21	3
31	911	19	3
34	0	15	1
35	0	19	1
36	0	15	2
37	0	19	2
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                               4961.dat                                                                                            0000600 0004000 0002000 00000000172 14572041001 0014247 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        11	911	2024-02-10	2024-02-11	80	90	100
13	108	2024-03-03	2024-03-06	100	90	60
16	0	2024-03-07	2024-03-09	100	100	100
\.


                                                                                                                                                                                                                                                                                                                                                                                                      4981.dat                                                                                            0000600 0004000 0002000 00000000033 14572041001 0014245 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        911	4
108	2
108	4
0	2
\.


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     restore.sql                                                                                         0000600 0004000 0002000 00000106133 14572041001 0015362 0                                                                                                    ustar 00postgres                        postgres                        0000000 0000000                                                                                                                                                                        --
-- NOTE:
--
-- File paths need to be edited. Search for $$PATH$$ and
-- replace it with the path to the directory containing
-- the extracted data files.
--
--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1
-- Dumped by pg_dump version 16.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

DROP DATABASE training_module_db;
--
-- Name: training_module_db; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE training_module_db WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';


ALTER DATABASE training_module_db OWNER TO postgres;

\connect training_module_db

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: admin_records; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.admin_records (
    admin_id bigint NOT NULL,
    first_name character varying(250),
    last_name character varying(250),
    mobile character varying(10),
    email character varying(150)
);


ALTER TABLE public.admin_records OWNER TO postgres;

--
-- Name: create_training_programs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.create_training_programs (
    training_program_id bigint NOT NULL,
    name character varying(150),
    training_desc character varying(500),
    training_status boolean
);


ALTER TABLE public.create_training_programs OWNER TO postgres;

--
-- Name: training_reports; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.training_reports (
    id integer NOT NULL,
    training_program_id bigint NOT NULL,
    start_date date,
    end_date date,
    attendance integer,
    participation integer,
    completion_rate double precision
);


ALTER TABLE public.training_reports OWNER TO postgres;

--
-- Name: date_summary_reports; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.date_summary_reports AS
 SELECT ctp.training_program_id,
    ctp.name AS training_program_name,
    tr.start_date,
    tr.end_date
   FROM (public.create_training_programs ctp
     JOIN public.training_reports tr ON ((ctp.training_program_id = tr.training_program_id)))
  GROUP BY ctp.training_program_id, ctp.name, tr.start_date, tr.end_date;


ALTER VIEW public.date_summary_reports OWNER TO postgres;

--
-- Name: department; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.department (
    department_id bigint NOT NULL,
    department_name character varying(150)
);


ALTER TABLE public.department OWNER TO postgres;

--
-- Name: training_relations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.training_relations (
    id integer NOT NULL,
    training_program_id bigint,
    job_post_id bigint,
    department_id bigint
);


ALTER TABLE public.training_relations OWNER TO postgres;

--
-- Name: department_summary_reports; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.department_summary_reports AS
 SELECT tr.training_program_id,
    ctp.name AS training_program_name,
    tr.department_id,
    d.department_name
   FROM ((public.create_training_programs ctp
     JOIN public.training_relations tr ON ((ctp.training_program_id = tr.training_program_id)))
     JOIN public.department d ON ((tr.department_id = d.department_id)));


ALTER VIEW public.department_summary_reports OWNER TO postgres;

--
-- Name: emp_training_relation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.emp_training_relation (
    emp_id bigint NOT NULL,
    training_program_id bigint NOT NULL
);


ALTER TABLE public.emp_training_relation OWNER TO postgres;

--
-- Name: employee_records; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employee_records (
    emp_id integer NOT NULL,
    emp_first_name character varying(150),
    emp_last_name character varying(150),
    emp_mobile character varying(10),
    emp_email character varying(250),
    emp_image character varying(500),
    emp_status boolean,
    job_post_id bigint,
    department_id bigint
);


ALTER TABLE public.employee_records OWNER TO postgres;

--
-- Name: employee_records_emp_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.employee_records_emp_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.employee_records_emp_id_seq OWNER TO postgres;

--
-- Name: employee_records_emp_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.employee_records_emp_id_seq OWNED BY public.employee_records.emp_id;


--
-- Name: employee_reports; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employee_reports (
    emp_id bigint NOT NULL,
    training_program_id bigint NOT NULL,
    employee_performance double precision,
    questionnaire1_result double precision,
    questionnaire2_result double precision
);


ALTER TABLE public.employee_reports OWNER TO postgres;

--
-- Name: employee_summary_reports; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.employee_summary_reports AS
 SELECT e.emp_id,
    e.emp_first_name,
    e.emp_last_name,
    er.training_program_id,
    er.questionnaire1_result,
    er.questionnaire2_result
   FROM (public.employee_records e
     JOIN public.employee_reports er ON ((e.emp_id = er.emp_id)));


ALTER VIEW public.employee_summary_reports OWNER TO postgres;

--
-- Name: job_post; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_post (
    job_post_id integer NOT NULL,
    job_post_name character varying(250)
);


ALTER TABLE public.job_post OWNER TO postgres;

--
-- Name: job_post_job_post_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.job_post_job_post_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.job_post_job_post_id_seq OWNER TO postgres;

--
-- Name: job_post_job_post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.job_post_job_post_id_seq OWNED BY public.job_post.job_post_id;


--
-- Name: login_credentials_admin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.login_credentials_admin (
    admin_id bigint NOT NULL,
    username character varying(30) NOT NULL,
    password character varying(20),
    status boolean
);


ALTER TABLE public.login_credentials_admin OWNER TO postgres;

--
-- Name: login_credentials_trainers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.login_credentials_trainers (
    trainer_id bigint NOT NULL,
    username character varying(20) NOT NULL,
    password character varying(15),
    status boolean
);


ALTER TABLE public.login_credentials_trainers OWNER TO postgres;

--
-- Name: mcq_options; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.mcq_options (
    ques_id bigint NOT NULL,
    option_1 character varying(100),
    option_2 character varying(100),
    option_3 character varying(100),
    option_4 character varying(100)
);


ALTER TABLE public.mcq_options OWNER TO postgres;

--
-- Name: month_summary_reports; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.month_summary_reports AS
 SELECT ctp.training_program_id,
    ctp.name AS training_program_name,
    EXTRACT(year FROM tr.start_date) AS year,
    EXTRACT(month FROM tr.start_date) AS month,
    count(*) AS program_count
   FROM (public.create_training_programs ctp
     JOIN public.training_reports tr ON ((ctp.training_program_id = tr.training_program_id)))
  GROUP BY ctp.training_program_id, ctp.name, (EXTRACT(year FROM tr.start_date)), (EXTRACT(month FROM tr.start_date));


ALTER VIEW public.month_summary_reports OWNER TO postgres;

--
-- Name: post_student_ans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.post_student_ans (
    id integer NOT NULL,
    ques_id bigint NOT NULL,
    emp_id bigint,
    post_student_ans character varying(3000)
);


ALTER TABLE public.post_student_ans OWNER TO postgres;

--
-- Name: post_student_ans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.post_student_ans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.post_student_ans_id_seq OWNER TO postgres;

--
-- Name: post_student_ans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.post_student_ans_id_seq OWNED BY public.post_student_ans.id;


--
-- Name: pre_post_result; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pre_post_result (
    training_program_id bigint NOT NULL,
    pre_result double precision,
    post_result double precision
);


ALTER TABLE public.pre_post_result OWNER TO postgres;

--
-- Name: pre_student_ans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pre_student_ans (
    id integer NOT NULL,
    ques_id bigint NOT NULL,
    emp_id bigint,
    pre_student_ans character varying(3000)
);


ALTER TABLE public.pre_student_ans OWNER TO postgres;

--
-- Name: pre_student_ans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pre_student_ans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pre_student_ans_id_seq OWNER TO postgres;

--
-- Name: pre_student_ans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pre_student_ans_id_seq OWNED BY public.pre_student_ans.id;


--
-- Name: questions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.questions (
    ques_id integer NOT NULL,
    que_text character varying(2000),
    training_program_id bigint,
    ques_type character varying
);


ALTER TABLE public.questions OWNER TO postgres;

--
-- Name: question_details; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.question_details AS
 SELECT q.ques_id,
    q.que_text,
    q.training_program_id,
    q.ques_type,
    mo.option_1,
    mo.option_2,
    mo.option_3,
    mo.option_4
   FROM (public.questions q
     LEFT JOIN public.mcq_options mo ON ((q.ques_id = mo.ques_id)));


ALTER VIEW public.question_details OWNER TO postgres;

--
-- Name: questions_ques_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.questions_ques_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.questions_ques_id_seq OWNER TO postgres;

--
-- Name: questions_ques_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.questions_ques_id_seq OWNED BY public.questions.ques_id;


--
-- Name: trainer_records; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.trainer_records (
    trainer_id bigint NOT NULL,
    first_name character varying(250),
    last_name character varying(250),
    mobile character varying(10),
    email character varying(150)
);


ALTER TABLE public.trainer_records OWNER TO postgres;

--
-- Name: training_trainer_relation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.training_trainer_relation (
    training_program_id bigint NOT NULL,
    trainer_id bigint NOT NULL
);


ALTER TABLE public.training_trainer_relation OWNER TO postgres;

--
-- Name: trainer_summary_reports; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.trainer_summary_reports AS
 SELECT t.trainer_id,
    concat(t.first_name, ' ', t.last_name) AS trainer_name,
    ctp.training_program_id,
    ctp.name AS training_program_name
   FROM ((public.trainer_records t
     LEFT JOIN public.training_trainer_relation rel ON ((t.trainer_id = rel.trainer_id)))
     LEFT JOIN public.create_training_programs ctp ON ((rel.training_program_id = ctp.training_program_id)));


ALTER VIEW public.trainer_summary_reports OWNER TO postgres;

--
-- Name: training_images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.training_images (
    id integer NOT NULL,
    training_program_id bigint NOT NULL,
    image character varying(300)
);


ALTER TABLE public.training_images OWNER TO postgres;

--
-- Name: training_images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.training_images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.training_images_id_seq OWNER TO postgres;

--
-- Name: training_images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.training_images_id_seq OWNED BY public.training_images.id;


--
-- Name: training_relations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.training_relations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.training_relations_id_seq OWNER TO postgres;

--
-- Name: training_relations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.training_relations_id_seq OWNED BY public.training_relations.id;


--
-- Name: training_reports_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.training_reports_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.training_reports_id_seq OWNER TO postgres;

--
-- Name: training_reports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.training_reports_id_seq OWNED BY public.training_reports.id;


--
-- Name: training_summary_reports; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.training_summary_reports AS
 SELECT t.training_program_id,
    t.name AS training_program_name,
    tr.start_date,
    tr.end_date,
    tr.attendance,
    tr.participation,
    t.training_status AS status,
    tr.completion_rate,
    ppr.pre_result,
    ppr.post_result,
    jp.job_post_name,
    d.department_name,
    ti.image AS training_image,
    t.training_desc,
    tt.trainer_id,
    trr.first_name AS trainer_first_name
   FROM ((((((((public.create_training_programs t
     JOIN public.training_reports tr ON ((t.training_program_id = tr.training_program_id)))
     JOIN public.pre_post_result ppr ON ((t.training_program_id = ppr.training_program_id)))
     JOIN public.training_relations trl ON ((t.training_program_id = trl.training_program_id)))
     JOIN public.job_post jp ON ((trl.job_post_id = jp.job_post_id)))
     JOIN public.department d ON ((trl.department_id = d.department_id)))
     JOIN public.training_images ti ON ((t.training_program_id = ti.training_program_id)))
     JOIN public.training_trainer_relation tt ON ((t.training_program_id = tt.training_program_id)))
     JOIN public.trainer_records trr ON ((tt.trainer_id = trr.trainer_id)));


ALTER VIEW public.training_summary_reports OWNER TO postgres;

--
-- Name: employee_records emp_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_records ALTER COLUMN emp_id SET DEFAULT nextval('public.employee_records_emp_id_seq'::regclass);


--
-- Name: job_post job_post_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_post ALTER COLUMN job_post_id SET DEFAULT nextval('public.job_post_job_post_id_seq'::regclass);


--
-- Name: post_student_ans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post_student_ans ALTER COLUMN id SET DEFAULT nextval('public.post_student_ans_id_seq'::regclass);


--
-- Name: pre_student_ans id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pre_student_ans ALTER COLUMN id SET DEFAULT nextval('public.pre_student_ans_id_seq'::regclass);


--
-- Name: questions ques_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questions ALTER COLUMN ques_id SET DEFAULT nextval('public.questions_ques_id_seq'::regclass);


--
-- Name: training_images id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_images ALTER COLUMN id SET DEFAULT nextval('public.training_images_id_seq'::regclass);


--
-- Name: training_relations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_relations ALTER COLUMN id SET DEFAULT nextval('public.training_relations_id_seq'::regclass);


--
-- Name: training_reports id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_reports ALTER COLUMN id SET DEFAULT nextval('public.training_reports_id_seq'::regclass);


--
-- Data for Name: admin_records; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.admin_records (admin_id, first_name, last_name, mobile, email) FROM stdin;
\.
COPY public.admin_records (admin_id, first_name, last_name, mobile, email) FROM '$$PATH$$/4959.dat';

--
-- Data for Name: create_training_programs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.create_training_programs (training_program_id, name, training_desc, training_status) FROM stdin;
\.
COPY public.create_training_programs (training_program_id, name, training_desc, training_status) FROM '$$PATH$$/4960.dat';

--
-- Data for Name: department; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.department (department_id, department_name) FROM stdin;
\.
COPY public.department (department_id, department_name) FROM '$$PATH$$/4962.dat';

--
-- Data for Name: emp_training_relation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.emp_training_relation (emp_id, training_program_id) FROM stdin;
\.
COPY public.emp_training_relation (emp_id, training_program_id) FROM '$$PATH$$/4964.dat';

--
-- Data for Name: employee_records; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employee_records (emp_id, emp_first_name, emp_last_name, emp_mobile, emp_email, emp_image, emp_status, job_post_id, department_id) FROM stdin;
\.
COPY public.employee_records (emp_id, emp_first_name, emp_last_name, emp_mobile, emp_email, emp_image, emp_status, job_post_id, department_id) FROM '$$PATH$$/4965.dat';

--
-- Data for Name: employee_reports; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employee_reports (emp_id, training_program_id, employee_performance, questionnaire1_result, questionnaire2_result) FROM stdin;
\.
COPY public.employee_reports (emp_id, training_program_id, employee_performance, questionnaire1_result, questionnaire2_result) FROM '$$PATH$$/4967.dat';

--
-- Data for Name: job_post; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_post (job_post_id, job_post_name) FROM stdin;
\.
COPY public.job_post (job_post_id, job_post_name) FROM '$$PATH$$/4968.dat';

--
-- Data for Name: login_credentials_admin; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.login_credentials_admin (admin_id, username, password, status) FROM stdin;
\.
COPY public.login_credentials_admin (admin_id, username, password, status) FROM '$$PATH$$/4970.dat';

--
-- Data for Name: login_credentials_trainers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.login_credentials_trainers (trainer_id, username, password, status) FROM stdin;
\.
COPY public.login_credentials_trainers (trainer_id, username, password, status) FROM '$$PATH$$/4971.dat';

--
-- Data for Name: mcq_options; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.mcq_options (ques_id, option_1, option_2, option_3, option_4) FROM stdin;
\.
COPY public.mcq_options (ques_id, option_1, option_2, option_3, option_4) FROM '$$PATH$$/4972.dat';

--
-- Data for Name: post_student_ans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.post_student_ans (id, ques_id, emp_id, post_student_ans) FROM stdin;
\.
COPY public.post_student_ans (id, ques_id, emp_id, post_student_ans) FROM '$$PATH$$/4973.dat';

--
-- Data for Name: pre_post_result; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pre_post_result (training_program_id, pre_result, post_result) FROM stdin;
\.
COPY public.pre_post_result (training_program_id, pre_result, post_result) FROM '$$PATH$$/4975.dat';

--
-- Data for Name: pre_student_ans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pre_student_ans (id, ques_id, emp_id, pre_student_ans) FROM stdin;
\.
COPY public.pre_student_ans (id, ques_id, emp_id, pre_student_ans) FROM '$$PATH$$/4976.dat';

--
-- Data for Name: questions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.questions (ques_id, que_text, training_program_id, ques_type) FROM stdin;
\.
COPY public.questions (ques_id, que_text, training_program_id, ques_type) FROM '$$PATH$$/4978.dat';

--
-- Data for Name: trainer_records; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.trainer_records (trainer_id, first_name, last_name, mobile, email) FROM stdin;
\.
COPY public.trainer_records (trainer_id, first_name, last_name, mobile, email) FROM '$$PATH$$/4980.dat';

--
-- Data for Name: training_images; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.training_images (id, training_program_id, image) FROM stdin;
\.
COPY public.training_images (id, training_program_id, image) FROM '$$PATH$$/4982.dat';

--
-- Data for Name: training_relations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.training_relations (id, training_program_id, job_post_id, department_id) FROM stdin;
\.
COPY public.training_relations (id, training_program_id, job_post_id, department_id) FROM '$$PATH$$/4963.dat';

--
-- Data for Name: training_reports; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.training_reports (id, training_program_id, start_date, end_date, attendance, participation, completion_rate) FROM stdin;
\.
COPY public.training_reports (id, training_program_id, start_date, end_date, attendance, participation, completion_rate) FROM '$$PATH$$/4961.dat';

--
-- Data for Name: training_trainer_relation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.training_trainer_relation (training_program_id, trainer_id) FROM stdin;
\.
COPY public.training_trainer_relation (training_program_id, trainer_id) FROM '$$PATH$$/4981.dat';

--
-- Name: employee_records_emp_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.employee_records_emp_id_seq', 32, true);


--
-- Name: job_post_job_post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.job_post_job_post_id_seq', 23, true);


--
-- Name: post_student_ans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.post_student_ans_id_seq', 20, true);


--
-- Name: pre_student_ans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pre_student_ans_id_seq', 20, true);


--
-- Name: questions_ques_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.questions_ques_id_seq', 30, true);


--
-- Name: training_images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.training_images_id_seq', 8, true);


--
-- Name: training_relations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.training_relations_id_seq', 37, true);


--
-- Name: training_reports_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.training_reports_id_seq', 16, true);


--
-- Name: admin_records admin_records_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.admin_records
    ADD CONSTRAINT admin_records_pkey PRIMARY KEY (admin_id);


--
-- Name: create_training_programs create_training_programs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.create_training_programs
    ADD CONSTRAINT create_training_programs_pkey PRIMARY KEY (training_program_id);


--
-- Name: department department_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.department
    ADD CONSTRAINT department_pkey PRIMARY KEY (department_id);


--
-- Name: emp_training_relation emp_training_relation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT emp_training_relation_pkey PRIMARY KEY (emp_id, training_program_id);


--
-- Name: employee_records employee_records_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT employee_records_pkey PRIMARY KEY (emp_id);


--
-- Name: employee_reports employee_reports_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT employee_reports_pkey PRIMARY KEY (emp_id, training_program_id);


--
-- Name: job_post job_post_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_post
    ADD CONSTRAINT job_post_pkey PRIMARY KEY (job_post_id);


--
-- Name: login_credentials_admin login_credentials_admin_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.login_credentials_admin
    ADD CONSTRAINT login_credentials_admin_pkey PRIMARY KEY (admin_id, username);


--
-- Name: login_credentials_trainers login_credentials_trainers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.login_credentials_trainers
    ADD CONSTRAINT login_credentials_trainers_pkey PRIMARY KEY (trainer_id, username);


--
-- Name: mcq_options mcq_options_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mcq_options
    ADD CONSTRAINT mcq_options_pkey PRIMARY KEY (ques_id);


--
-- Name: post_student_ans post_student_ans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT post_student_ans_pkey PRIMARY KEY (id, ques_id);


--
-- Name: pre_post_result pre_post_result_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pre_post_result
    ADD CONSTRAINT pre_post_result_pkey PRIMARY KEY (training_program_id);


--
-- Name: pre_student_ans pre_student_ans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT pre_student_ans_pkey PRIMARY KEY (id, ques_id);


--
-- Name: questions questions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (ques_id);


--
-- Name: trainer_records trainer_records_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.trainer_records
    ADD CONSTRAINT trainer_records_pkey PRIMARY KEY (trainer_id);


--
-- Name: training_images training_images_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_images
    ADD CONSTRAINT training_images_pkey PRIMARY KEY (id, training_program_id);


--
-- Name: training_relations training_relations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT training_relations_pkey PRIMARY KEY (id);


--
-- Name: training_reports training_reports_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_reports
    ADD CONSTRAINT training_reports_pkey PRIMARY KEY (id, training_program_id);


--
-- Name: training_trainer_relation training_trainer_relation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT training_trainer_relation_pkey PRIMARY KEY (training_program_id, trainer_id);


--
-- Name: emp_training_relation FK_emp_training_relation.emp_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT "FK_emp_training_relation.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: emp_training_relation FK_emp_training_relation.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT "FK_emp_training_relation.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: employee_reports FK_employee_reports.emp_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT "FK_employee_reports.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: employee_reports FK_employee_reports.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT "FK_employee_reports.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: login_credentials_admin FK_login_credentials_admin.admin_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.login_credentials_admin
    ADD CONSTRAINT "FK_login_credentials_admin.admin_id" FOREIGN KEY (admin_id) REFERENCES public.admin_records(admin_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: login_credentials_trainers FK_login_credentials_trainers.trainer_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.login_credentials_trainers
    ADD CONSTRAINT "FK_login_credentials_trainers.trainer_id" FOREIGN KEY (trainer_id) REFERENCES public.trainer_records(trainer_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: mcq_options FK_mcq_options.ques_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.mcq_options
    ADD CONSTRAINT "FK_mcq_options.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: post_student_ans FK_post_student_ans.emp_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT "FK_post_student_ans.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id);


--
-- Name: post_student_ans FK_post_student_ans.ques_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT "FK_post_student_ans.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id);


--
-- Name: pre_post_result FK_pre_post_result.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pre_post_result
    ADD CONSTRAINT "FK_pre_post_result.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: pre_student_ans FK_pre_student_ans.emp_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT "FK_pre_student_ans.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id);


--
-- Name: pre_student_ans FK_pre_student_ans.ques_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT "FK_pre_student_ans.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id);


--
-- Name: questions FK_questions.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT "FK_questions.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: training_images FK_training_images.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_images
    ADD CONSTRAINT "FK_training_images.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: training_relations FK_training_relations.department_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.department_id" FOREIGN KEY (department_id) REFERENCES public.department(department_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: training_relations FK_training_relations.job_post_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.job_post_id" FOREIGN KEY (job_post_id) REFERENCES public.job_post(job_post_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: training_relations FK_training_relations.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: training_reports FK_training_reports.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_reports
    ADD CONSTRAINT "FK_training_reports.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: training_trainer_relation FK_training_trainer_relation.trainer_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT "FK_training_trainer_relation.trainer_id" FOREIGN KEY (trainer_id) REFERENCES public.trainer_records(trainer_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: training_trainer_relation FK_training_trainer_relation.training_program_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT "FK_training_trainer_relation.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: employee_records fk_constraint_department_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT fk_constraint_department_id FOREIGN KEY (department_id) REFERENCES public.department(department_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: employee_records fk_constraint_job_post; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT fk_constraint_job_post FOREIGN KEY (job_post_id) REFERENCES public.job_post(job_post_id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     