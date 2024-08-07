PGDMP      3                |            training_module_db    16.3    16.3 {    ~           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    16397    training_module_db    DATABASE     �   CREATE DATABASE training_module_db WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
 "   DROP DATABASE training_module_db;
                postgres    false            �            1259    16398    admin_records    TABLE     �   CREATE TABLE public.admin_records (
    admin_id bigint NOT NULL,
    first_name character varying(250),
    last_name character varying(250),
    mobile character varying(10),
    email character varying(150)
);
 !   DROP TABLE public.admin_records;
       public         heap    postgres    false            �            1259    16403    create_training_programs    TABLE     �   CREATE TABLE public.create_training_programs (
    training_program_id bigint NOT NULL,
    name character varying(150),
    training_desc character varying(500),
    training_status boolean
);
 ,   DROP TABLE public.create_training_programs;
       public         heap    postgres    false            �            1259    16408    training_reports    TABLE     �   CREATE TABLE public.training_reports (
    id integer NOT NULL,
    training_program_id bigint NOT NULL,
    start_date date,
    end_date date,
    attendance integer,
    participation integer,
    completion_rate double precision
);
 $   DROP TABLE public.training_reports;
       public         heap    postgres    false            �            1259    16411    date_summary_reports    VIEW     k  CREATE VIEW public.date_summary_reports AS
 SELECT ctp.training_program_id,
    ctp.name AS training_program_name,
    tr.start_date,
    tr.end_date
   FROM (public.create_training_programs ctp
     JOIN public.training_reports tr ON ((ctp.training_program_id = tr.training_program_id)))
  GROUP BY ctp.training_program_id, ctp.name, tr.start_date, tr.end_date;
 '   DROP VIEW public.date_summary_reports;
       public          postgres    false    216    217    217    217    216            �            1259    16415 
   department    TABLE     r   CREATE TABLE public.department (
    department_id bigint NOT NULL,
    department_name character varying(150)
);
    DROP TABLE public.department;
       public         heap    postgres    false            �            1259    16418    training_relations    TABLE     �   CREATE TABLE public.training_relations (
    id integer NOT NULL,
    training_program_id bigint,
    job_post_id bigint,
    department_id bigint
);
 &   DROP TABLE public.training_relations;
       public         heap    postgres    false            �            1259    16421    department_summary_reports    VIEW     |  CREATE VIEW public.department_summary_reports AS
 SELECT tr.training_program_id,
    ctp.name AS training_program_name,
    tr.department_id,
    d.department_name
   FROM ((public.create_training_programs ctp
     JOIN public.training_relations tr ON ((ctp.training_program_id = tr.training_program_id)))
     JOIN public.department d ON ((tr.department_id = d.department_id)));
 -   DROP VIEW public.department_summary_reports;
       public          postgres    false    216    220    220    216    219    219            �            1259    16425    emp_training_relation    TABLE     s   CREATE TABLE public.emp_training_relation (
    emp_id bigint NOT NULL,
    training_program_id bigint NOT NULL
);
 )   DROP TABLE public.emp_training_relation;
       public         heap    postgres    false            �            1259    16428    employee_records    TABLE     l  CREATE TABLE public.employee_records (
    emp_id integer NOT NULL,
    emp_first_name character varying(150),
    emp_last_name character varying(150),
    emp_mobile character varying(10),
    emp_email character varying(250),
    emp_image character varying(500),
    emp_status boolean,
    job_post_id bigint,
    department_id bigint,
    emp_uid integer
);
 $   DROP TABLE public.employee_records;
       public         heap    postgres    false            �            1259    16433    employee_records_emp_id_seq    SEQUENCE     �   CREATE SEQUENCE public.employee_records_emp_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 2   DROP SEQUENCE public.employee_records_emp_id_seq;
       public          postgres    false    223            �           0    0    employee_records_emp_id_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE public.employee_records_emp_id_seq OWNED BY public.employee_records.emp_id;
          public          postgres    false    224            �            1259    16434    employee_reports    TABLE     �   CREATE TABLE public.employee_reports (
    emp_id bigint NOT NULL,
    training_program_id bigint NOT NULL,
    employee_performance double precision,
    questionnaire1_result double precision,
    questionnaire2_result double precision
);
 $   DROP TABLE public.employee_reports;
       public         heap    postgres    false            �            1259    16437    employee_summary_reports    VIEW     )  CREATE VIEW public.employee_summary_reports AS
 SELECT e.emp_id,
    e.emp_first_name,
    e.emp_last_name,
    er.training_program_id,
    er.questionnaire1_result,
    er.questionnaire2_result
   FROM (public.employee_records e
     JOIN public.employee_reports er ON ((e.emp_id = er.emp_id)));
 +   DROP VIEW public.employee_summary_reports;
       public          postgres    false    225    223    225    225    223    225    223            �            1259    16441    job_post    TABLE     m   CREATE TABLE public.job_post (
    job_post_id integer NOT NULL,
    job_post_name character varying(250)
);
    DROP TABLE public.job_post;
       public         heap    postgres    false            �            1259    16444    job_post_job_post_id_seq    SEQUENCE     �   CREATE SEQUENCE public.job_post_job_post_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.job_post_job_post_id_seq;
       public          postgres    false    227            �           0    0    job_post_job_post_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.job_post_job_post_id_seq OWNED BY public.job_post.job_post_id;
          public          postgres    false    228            �            1259    16445    login_credentials_admin    TABLE     �   CREATE TABLE public.login_credentials_admin (
    admin_id bigint NOT NULL,
    username character varying(30) NOT NULL,
    password character varying(20),
    status boolean
);
 +   DROP TABLE public.login_credentials_admin;
       public         heap    postgres    false            �            1259    16448    login_credentials_trainers    TABLE     �   CREATE TABLE public.login_credentials_trainers (
    trainer_id bigint NOT NULL,
    username character varying(20) NOT NULL,
    password character varying(15),
    status boolean
);
 .   DROP TABLE public.login_credentials_trainers;
       public         heap    postgres    false            �            1259    16451    mcq_options    TABLE     �   CREATE TABLE public.mcq_options (
    ques_id bigint NOT NULL,
    option_1 character varying(100),
    option_2 character varying(100),
    option_3 character varying(100),
    option_4 character varying(100)
);
    DROP TABLE public.mcq_options;
       public         heap    postgres    false            �            1259    16454    month_summary_reports    VIEW     �  CREATE VIEW public.month_summary_reports AS
 SELECT ctp.training_program_id,
    ctp.name AS training_program_name,
    EXTRACT(year FROM tr.start_date) AS year,
    EXTRACT(month FROM tr.start_date) AS month,
    count(*) AS program_count
   FROM (public.create_training_programs ctp
     JOIN public.training_reports tr ON ((ctp.training_program_id = tr.training_program_id)))
  GROUP BY ctp.training_program_id, ctp.name, (EXTRACT(year FROM tr.start_date)), (EXTRACT(month FROM tr.start_date));
 (   DROP VIEW public.month_summary_reports;
       public          postgres    false    217    216    217    216            �            1259    16459    post_student_ans    TABLE     �   CREATE TABLE public.post_student_ans (
    id integer NOT NULL,
    ques_id bigint NOT NULL,
    emp_id bigint,
    post_student_ans character varying(3000)
);
 $   DROP TABLE public.post_student_ans;
       public         heap    postgres    false            �            1259    16464    post_student_ans_id_seq    SEQUENCE     �   CREATE SEQUENCE public.post_student_ans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.post_student_ans_id_seq;
       public          postgres    false    233            �           0    0    post_student_ans_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.post_student_ans_id_seq OWNED BY public.post_student_ans.id;
          public          postgres    false    234            �            1259    16465    pre_post_result    TABLE     �   CREATE TABLE public.pre_post_result (
    training_program_id bigint NOT NULL,
    pre_result double precision,
    post_result double precision
);
 #   DROP TABLE public.pre_post_result;
       public         heap    postgres    false            �            1259    16468    pre_student_ans    TABLE     �   CREATE TABLE public.pre_student_ans (
    id integer NOT NULL,
    ques_id bigint NOT NULL,
    emp_id bigint,
    pre_student_ans character varying(3000)
);
 #   DROP TABLE public.pre_student_ans;
       public         heap    postgres    false            �            1259    16473    pre_student_ans_id_seq    SEQUENCE     �   CREATE SEQUENCE public.pre_student_ans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.pre_student_ans_id_seq;
       public          postgres    false    236            �           0    0    pre_student_ans_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.pre_student_ans_id_seq OWNED BY public.pre_student_ans.id;
          public          postgres    false    237            �            1259    16474 	   questions    TABLE     �   CREATE TABLE public.questions (
    ques_id integer NOT NULL,
    que_text character varying(2000),
    training_program_id bigint,
    ques_type character varying
);
    DROP TABLE public.questions;
       public         heap    postgres    false            �            1259    16479    question_details    VIEW       CREATE VIEW public.question_details AS
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
       public          postgres    false    238    238    231    231    231    231    231    238    238            �            1259    16483    questions_ques_id_seq    SEQUENCE     �   CREATE SEQUENCE public.questions_ques_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.questions_ques_id_seq;
       public          postgres    false    238            �           0    0    questions_ques_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.questions_ques_id_seq OWNED BY public.questions.ques_id;
          public          postgres    false    240            �            1259    16484    trainer_records    TABLE     �   CREATE TABLE public.trainer_records (
    trainer_id bigint NOT NULL,
    first_name character varying(250),
    last_name character varying(250),
    mobile character varying(10),
    email character varying(150)
);
 #   DROP TABLE public.trainer_records;
       public         heap    postgres    false            �            1259    16489    training_trainer_relation    TABLE     {   CREATE TABLE public.training_trainer_relation (
    training_program_id bigint NOT NULL,
    trainer_id bigint NOT NULL
);
 -   DROP TABLE public.training_trainer_relation;
       public         heap    postgres    false            �            1259    16492    trainer_summary_reports    VIEW     �  CREATE VIEW public.trainer_summary_reports AS
 SELECT t.trainer_id,
    concat(t.first_name, ' ', t.last_name) AS trainer_name,
    ctp.training_program_id,
    ctp.name AS training_program_name
   FROM ((public.trainer_records t
     LEFT JOIN public.training_trainer_relation rel ON ((t.trainer_id = rel.trainer_id)))
     LEFT JOIN public.create_training_programs ctp ON ((rel.training_program_id = ctp.training_program_id)));
 *   DROP VIEW public.trainer_summary_reports;
       public          postgres    false    216    241    241    241    242    242    216            �            1259    16496    training_images    TABLE     �   CREATE TABLE public.training_images (
    id integer NOT NULL,
    training_program_id bigint NOT NULL,
    image character varying(300)
);
 #   DROP TABLE public.training_images;
       public         heap    postgres    false            �            1259    16499    training_images_id_seq    SEQUENCE     �   CREATE SEQUENCE public.training_images_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.training_images_id_seq;
       public          postgres    false    244            �           0    0    training_images_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.training_images_id_seq OWNED BY public.training_images.id;
          public          postgres    false    245            �            1259    16500    training_relations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.training_relations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.training_relations_id_seq;
       public          postgres    false    220            �           0    0    training_relations_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.training_relations_id_seq OWNED BY public.training_relations.id;
          public          postgres    false    246            �            1259    16501    training_reports_id_seq    SEQUENCE     �   CREATE SEQUENCE public.training_reports_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.training_reports_id_seq;
       public          postgres    false    217            �           0    0    training_reports_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.training_reports_id_seq OWNED BY public.training_reports.id;
          public          postgres    false    247            �            1259    16502    training_summary_reports    VIEW     �  CREATE VIEW public.training_summary_reports AS
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
       public          postgres    false    227    216    216    216    216    217    217    217    217    217    217    219    219    220    220    220    227    235    235    235    241    241    242    242    244    244            �           2604    16507    employee_records emp_id    DEFAULT     �   ALTER TABLE ONLY public.employee_records ALTER COLUMN emp_id SET DEFAULT nextval('public.employee_records_emp_id_seq'::regclass);
 F   ALTER TABLE public.employee_records ALTER COLUMN emp_id DROP DEFAULT;
       public          postgres    false    224    223            �           2604    16508    job_post job_post_id    DEFAULT     |   ALTER TABLE ONLY public.job_post ALTER COLUMN job_post_id SET DEFAULT nextval('public.job_post_job_post_id_seq'::regclass);
 C   ALTER TABLE public.job_post ALTER COLUMN job_post_id DROP DEFAULT;
       public          postgres    false    228    227            �           2604    16509    post_student_ans id    DEFAULT     z   ALTER TABLE ONLY public.post_student_ans ALTER COLUMN id SET DEFAULT nextval('public.post_student_ans_id_seq'::regclass);
 B   ALTER TABLE public.post_student_ans ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    234    233            �           2604    16510    pre_student_ans id    DEFAULT     x   ALTER TABLE ONLY public.pre_student_ans ALTER COLUMN id SET DEFAULT nextval('public.pre_student_ans_id_seq'::regclass);
 A   ALTER TABLE public.pre_student_ans ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    237    236            �           2604    16511    questions ques_id    DEFAULT     v   ALTER TABLE ONLY public.questions ALTER COLUMN ques_id SET DEFAULT nextval('public.questions_ques_id_seq'::regclass);
 @   ALTER TABLE public.questions ALTER COLUMN ques_id DROP DEFAULT;
       public          postgres    false    240    238            �           2604    16512    training_images id    DEFAULT     x   ALTER TABLE ONLY public.training_images ALTER COLUMN id SET DEFAULT nextval('public.training_images_id_seq'::regclass);
 A   ALTER TABLE public.training_images ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    245    244            �           2604    16513    training_relations id    DEFAULT     ~   ALTER TABLE ONLY public.training_relations ALTER COLUMN id SET DEFAULT nextval('public.training_relations_id_seq'::regclass);
 D   ALTER TABLE public.training_relations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    246    220            �           2604    16514    training_reports id    DEFAULT     z   ALTER TABLE ONLY public.training_reports ALTER COLUMN id SET DEFAULT nextval('public.training_reports_id_seq'::regclass);
 B   ALTER TABLE public.training_reports ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    247    217            a          0    16398    admin_records 
   TABLE DATA           W   COPY public.admin_records (admin_id, first_name, last_name, mobile, email) FROM stdin;
    public          postgres    false    215   ��       b          0    16403    create_training_programs 
   TABLE DATA           m   COPY public.create_training_programs (training_program_id, name, training_desc, training_status) FROM stdin;
    public          postgres    false    216   ,�       d          0    16415 
   department 
   TABLE DATA           D   COPY public.department (department_id, department_name) FROM stdin;
    public          postgres    false    219   �       f          0    16425    emp_training_relation 
   TABLE DATA           L   COPY public.emp_training_relation (emp_id, training_program_id) FROM stdin;
    public          postgres    false    222   A�       g          0    16428    employee_records 
   TABLE DATA           �   COPY public.employee_records (emp_id, emp_first_name, emp_last_name, emp_mobile, emp_email, emp_image, emp_status, job_post_id, department_id, emp_uid) FROM stdin;
    public          postgres    false    223   y�       i          0    16434    employee_reports 
   TABLE DATA           �   COPY public.employee_reports (emp_id, training_program_id, employee_performance, questionnaire1_result, questionnaire2_result) FROM stdin;
    public          postgres    false    225   h�       j          0    16441    job_post 
   TABLE DATA           >   COPY public.job_post (job_post_id, job_post_name) FROM stdin;
    public          postgres    false    227   ��       l          0    16445    login_credentials_admin 
   TABLE DATA           W   COPY public.login_credentials_admin (admin_id, username, password, status) FROM stdin;
    public          postgres    false    229   H�       m          0    16448    login_credentials_trainers 
   TABLE DATA           \   COPY public.login_credentials_trainers (trainer_id, username, password, status) FROM stdin;
    public          postgres    false    230   ��       n          0    16451    mcq_options 
   TABLE DATA           V   COPY public.mcq_options (ques_id, option_1, option_2, option_3, option_4) FROM stdin;
    public          postgres    false    231   4�       o          0    16459    post_student_ans 
   TABLE DATA           Q   COPY public.post_student_ans (id, ques_id, emp_id, post_student_ans) FROM stdin;
    public          postgres    false    233   ��       q          0    16465    pre_post_result 
   TABLE DATA           W   COPY public.pre_post_result (training_program_id, pre_result, post_result) FROM stdin;
    public          postgres    false    235   Z�       r          0    16468    pre_student_ans 
   TABLE DATA           O   COPY public.pre_student_ans (id, ques_id, emp_id, pre_student_ans) FROM stdin;
    public          postgres    false    236   w�       t          0    16474 	   questions 
   TABLE DATA           V   COPY public.questions (ques_id, que_text, training_program_id, ques_type) FROM stdin;
    public          postgres    false    238   A�       v          0    16484    trainer_records 
   TABLE DATA           [   COPY public.trainer_records (trainer_id, first_name, last_name, mobile, email) FROM stdin;
    public          postgres    false    241   	�       x          0    16496    training_images 
   TABLE DATA           I   COPY public.training_images (id, training_program_id, image) FROM stdin;
    public          postgres    false    244   ��       e          0    16418    training_relations 
   TABLE DATA           a   COPY public.training_relations (id, training_program_id, job_post_id, department_id) FROM stdin;
    public          postgres    false    220   Y�       c          0    16408    training_reports 
   TABLE DATA           �   COPY public.training_reports (id, training_program_id, start_date, end_date, attendance, participation, completion_rate) FROM stdin;
    public          postgres    false    217   ��       w          0    16489    training_trainer_relation 
   TABLE DATA           T   COPY public.training_trainer_relation (training_program_id, trainer_id) FROM stdin;
    public          postgres    false    242    �       �           0    0    employee_records_emp_id_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('public.employee_records_emp_id_seq', 37, true);
          public          postgres    false    224            �           0    0    job_post_job_post_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.job_post_job_post_id_seq', 24, true);
          public          postgres    false    228            �           0    0    post_student_ans_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.post_student_ans_id_seq', 23, true);
          public          postgres    false    234            �           0    0    pre_student_ans_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.pre_student_ans_id_seq', 23, true);
          public          postgres    false    237            �           0    0    questions_ques_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.questions_ques_id_seq', 57, true);
          public          postgres    false    240            �           0    0    training_images_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.training_images_id_seq', 10, true);
          public          postgres    false    245            �           0    0    training_relations_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.training_relations_id_seq', 40, true);
          public          postgres    false    246            �           0    0    training_reports_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.training_reports_id_seq', 18, true);
          public          postgres    false    247            �           2606    16516     admin_records admin_records_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.admin_records
    ADD CONSTRAINT admin_records_pkey PRIMARY KEY (admin_id);
 J   ALTER TABLE ONLY public.admin_records DROP CONSTRAINT admin_records_pkey;
       public            postgres    false    215            �           2606    16518 6   create_training_programs create_training_programs_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.create_training_programs
    ADD CONSTRAINT create_training_programs_pkey PRIMARY KEY (training_program_id);
 `   ALTER TABLE ONLY public.create_training_programs DROP CONSTRAINT create_training_programs_pkey;
       public            postgres    false    216            �           2606    16520    department department_pkey 
   CONSTRAINT     c   ALTER TABLE ONLY public.department
    ADD CONSTRAINT department_pkey PRIMARY KEY (department_id);
 D   ALTER TABLE ONLY public.department DROP CONSTRAINT department_pkey;
       public            postgres    false    219            �           2606    16522 0   emp_training_relation emp_training_relation_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT emp_training_relation_pkey PRIMARY KEY (emp_id, training_program_id);
 Z   ALTER TABLE ONLY public.emp_training_relation DROP CONSTRAINT emp_training_relation_pkey;
       public            postgres    false    222    222            �           2606    24577 -   employee_records employee_records_emp_uid_key 
   CONSTRAINT     k   ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT employee_records_emp_uid_key UNIQUE (emp_uid);
 W   ALTER TABLE ONLY public.employee_records DROP CONSTRAINT employee_records_emp_uid_key;
       public            postgres    false    223            �           2606    16524 &   employee_records employee_records_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT employee_records_pkey PRIMARY KEY (emp_id);
 P   ALTER TABLE ONLY public.employee_records DROP CONSTRAINT employee_records_pkey;
       public            postgres    false    223            �           2606    16526 &   employee_reports employee_reports_pkey 
   CONSTRAINT     }   ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT employee_reports_pkey PRIMARY KEY (emp_id, training_program_id);
 P   ALTER TABLE ONLY public.employee_reports DROP CONSTRAINT employee_reports_pkey;
       public            postgres    false    225    225            �           2606    16528    job_post job_post_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.job_post
    ADD CONSTRAINT job_post_pkey PRIMARY KEY (job_post_id);
 @   ALTER TABLE ONLY public.job_post DROP CONSTRAINT job_post_pkey;
       public            postgres    false    227            �           2606    16530 4   login_credentials_admin login_credentials_admin_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_admin
    ADD CONSTRAINT login_credentials_admin_pkey PRIMARY KEY (admin_id, username);
 ^   ALTER TABLE ONLY public.login_credentials_admin DROP CONSTRAINT login_credentials_admin_pkey;
       public            postgres    false    229    229            �           2606    16532 :   login_credentials_trainers login_credentials_trainers_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_trainers
    ADD CONSTRAINT login_credentials_trainers_pkey PRIMARY KEY (trainer_id, username);
 d   ALTER TABLE ONLY public.login_credentials_trainers DROP CONSTRAINT login_credentials_trainers_pkey;
       public            postgres    false    230    230            �           2606    16534    mcq_options mcq_options_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.mcq_options
    ADD CONSTRAINT mcq_options_pkey PRIMARY KEY (ques_id);
 F   ALTER TABLE ONLY public.mcq_options DROP CONSTRAINT mcq_options_pkey;
       public            postgres    false    231            �           2606    16536 &   post_student_ans post_student_ans_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT post_student_ans_pkey PRIMARY KEY (id, ques_id);
 P   ALTER TABLE ONLY public.post_student_ans DROP CONSTRAINT post_student_ans_pkey;
       public            postgres    false    233    233            �           2606    16538 $   pre_post_result pre_post_result_pkey 
   CONSTRAINT     s   ALTER TABLE ONLY public.pre_post_result
    ADD CONSTRAINT pre_post_result_pkey PRIMARY KEY (training_program_id);
 N   ALTER TABLE ONLY public.pre_post_result DROP CONSTRAINT pre_post_result_pkey;
       public            postgres    false    235            �           2606    16540 $   pre_student_ans pre_student_ans_pkey 
   CONSTRAINT     k   ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT pre_student_ans_pkey PRIMARY KEY (id, ques_id);
 N   ALTER TABLE ONLY public.pre_student_ans DROP CONSTRAINT pre_student_ans_pkey;
       public            postgres    false    236    236            �           2606    16542    questions questions_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (ques_id);
 B   ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_pkey;
       public            postgres    false    238            �           2606    16544 $   trainer_records trainer_records_pkey 
   CONSTRAINT     j   ALTER TABLE ONLY public.trainer_records
    ADD CONSTRAINT trainer_records_pkey PRIMARY KEY (trainer_id);
 N   ALTER TABLE ONLY public.trainer_records DROP CONSTRAINT trainer_records_pkey;
       public            postgres    false    241            �           2606    16546 $   training_images training_images_pkey 
   CONSTRAINT     w   ALTER TABLE ONLY public.training_images
    ADD CONSTRAINT training_images_pkey PRIMARY KEY (id, training_program_id);
 N   ALTER TABLE ONLY public.training_images DROP CONSTRAINT training_images_pkey;
       public            postgres    false    244    244            �           2606    16548 *   training_relations training_relations_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT training_relations_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT training_relations_pkey;
       public            postgres    false    220            �           2606    16550 &   training_reports training_reports_pkey 
   CONSTRAINT     y   ALTER TABLE ONLY public.training_reports
    ADD CONSTRAINT training_reports_pkey PRIMARY KEY (id, training_program_id);
 P   ALTER TABLE ONLY public.training_reports DROP CONSTRAINT training_reports_pkey;
       public            postgres    false    217    217            �           2606    16552 8   training_trainer_relation training_trainer_relation_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT training_trainer_relation_pkey PRIMARY KEY (training_program_id, trainer_id);
 b   ALTER TABLE ONLY public.training_trainer_relation DROP CONSTRAINT training_trainer_relation_pkey;
       public            postgres    false    242    242            �           2606    16553 5   emp_training_relation FK_emp_training_relation.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT "FK_emp_training_relation.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id) ON UPDATE CASCADE ON DELETE CASCADE;
 a   ALTER TABLE ONLY public.emp_training_relation DROP CONSTRAINT "FK_emp_training_relation.emp_id";
       public          postgres    false    223    222    4764            �           2606    16558 B   emp_training_relation FK_emp_training_relation.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.emp_training_relation
    ADD CONSTRAINT "FK_emp_training_relation.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 n   ALTER TABLE ONLY public.emp_training_relation DROP CONSTRAINT "FK_emp_training_relation.training_program_id";
       public          postgres    false    4752    222    216            �           2606    16563 +   employee_reports FK_employee_reports.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT "FK_employee_reports.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id) ON UPDATE CASCADE ON DELETE CASCADE;
 W   ALTER TABLE ONLY public.employee_reports DROP CONSTRAINT "FK_employee_reports.emp_id";
       public          postgres    false    4764    223    225            �           2606    16568 8   employee_reports FK_employee_reports.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_reports
    ADD CONSTRAINT "FK_employee_reports.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 d   ALTER TABLE ONLY public.employee_reports DROP CONSTRAINT "FK_employee_reports.training_program_id";
       public          postgres    false    216    4752    225            �           2606    16573 ;   login_credentials_admin FK_login_credentials_admin.admin_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_admin
    ADD CONSTRAINT "FK_login_credentials_admin.admin_id" FOREIGN KEY (admin_id) REFERENCES public.admin_records(admin_id) ON UPDATE CASCADE ON DELETE CASCADE;
 g   ALTER TABLE ONLY public.login_credentials_admin DROP CONSTRAINT "FK_login_credentials_admin.admin_id";
       public          postgres    false    215    229    4750            �           2606    16578 C   login_credentials_trainers FK_login_credentials_trainers.trainer_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.login_credentials_trainers
    ADD CONSTRAINT "FK_login_credentials_trainers.trainer_id" FOREIGN KEY (trainer_id) REFERENCES public.trainer_records(trainer_id) ON UPDATE CASCADE ON DELETE CASCADE;
 o   ALTER TABLE ONLY public.login_credentials_trainers DROP CONSTRAINT "FK_login_credentials_trainers.trainer_id";
       public          postgres    false    4784    230    241            �           2606    16583 "   mcq_options FK_mcq_options.ques_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.mcq_options
    ADD CONSTRAINT "FK_mcq_options.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id) ON UPDATE CASCADE ON DELETE CASCADE;
 N   ALTER TABLE ONLY public.mcq_options DROP CONSTRAINT "FK_mcq_options.ques_id";
       public          postgres    false    231    238    4782            �           2606    16588 +   post_student_ans FK_post_student_ans.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT "FK_post_student_ans.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id);
 W   ALTER TABLE ONLY public.post_student_ans DROP CONSTRAINT "FK_post_student_ans.emp_id";
       public          postgres    false    233    223    4764            �           2606    16593 ,   post_student_ans FK_post_student_ans.ques_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.post_student_ans
    ADD CONSTRAINT "FK_post_student_ans.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id);
 X   ALTER TABLE ONLY public.post_student_ans DROP CONSTRAINT "FK_post_student_ans.ques_id";
       public          postgres    false    233    4782    238            �           2606    16598 6   pre_post_result FK_pre_post_result.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.pre_post_result
    ADD CONSTRAINT "FK_pre_post_result.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.pre_post_result DROP CONSTRAINT "FK_pre_post_result.training_program_id";
       public          postgres    false    4752    235    216            �           2606    16603 )   pre_student_ans FK_pre_student_ans.emp_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT "FK_pre_student_ans.emp_id" FOREIGN KEY (emp_id) REFERENCES public.employee_records(emp_id);
 U   ALTER TABLE ONLY public.pre_student_ans DROP CONSTRAINT "FK_pre_student_ans.emp_id";
       public          postgres    false    4764    236    223            �           2606    16608 *   pre_student_ans FK_pre_student_ans.ques_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.pre_student_ans
    ADD CONSTRAINT "FK_pre_student_ans.ques_id" FOREIGN KEY (ques_id) REFERENCES public.questions(ques_id);
 V   ALTER TABLE ONLY public.pre_student_ans DROP CONSTRAINT "FK_pre_student_ans.ques_id";
       public          postgres    false    4782    238    236            �           2606    16613 *   questions FK_questions.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT "FK_questions.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 V   ALTER TABLE ONLY public.questions DROP CONSTRAINT "FK_questions.training_program_id";
       public          postgres    false    216    238    4752            �           2606    16618 6   training_images FK_training_images.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_images
    ADD CONSTRAINT "FK_training_images.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.training_images DROP CONSTRAINT "FK_training_images.training_program_id";
       public          postgres    false    244    4752    216            �           2606    16623 6   training_relations FK_training_relations.department_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.department_id" FOREIGN KEY (department_id) REFERENCES public.department(department_id) ON UPDATE CASCADE ON DELETE CASCADE;
 b   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT "FK_training_relations.department_id";
       public          postgres    false    220    4756    219            �           2606    16628 4   training_relations FK_training_relations.job_post_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.job_post_id" FOREIGN KEY (job_post_id) REFERENCES public.job_post(job_post_id) ON UPDATE CASCADE ON DELETE CASCADE;
 `   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT "FK_training_relations.job_post_id";
       public          postgres    false    4768    227    220            �           2606    16633 <   training_relations FK_training_relations.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_relations
    ADD CONSTRAINT "FK_training_relations.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 h   ALTER TABLE ONLY public.training_relations DROP CONSTRAINT "FK_training_relations.training_program_id";
       public          postgres    false    220    4752    216            �           2606    16638 8   training_reports FK_training_reports.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_reports
    ADD CONSTRAINT "FK_training_reports.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 d   ALTER TABLE ONLY public.training_reports DROP CONSTRAINT "FK_training_reports.training_program_id";
       public          postgres    false    216    4752    217            �           2606    16643 A   training_trainer_relation FK_training_trainer_relation.trainer_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT "FK_training_trainer_relation.trainer_id" FOREIGN KEY (trainer_id) REFERENCES public.trainer_records(trainer_id) ON UPDATE CASCADE ON DELETE CASCADE;
 m   ALTER TABLE ONLY public.training_trainer_relation DROP CONSTRAINT "FK_training_trainer_relation.trainer_id";
       public          postgres    false    241    242    4784            �           2606    16648 J   training_trainer_relation FK_training_trainer_relation.training_program_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.training_trainer_relation
    ADD CONSTRAINT "FK_training_trainer_relation.training_program_id" FOREIGN KEY (training_program_id) REFERENCES public.create_training_programs(training_program_id) ON UPDATE CASCADE ON DELETE CASCADE;
 v   ALTER TABLE ONLY public.training_trainer_relation DROP CONSTRAINT "FK_training_trainer_relation.training_program_id";
       public          postgres    false    242    4752    216            �           2606    16653 ,   employee_records fk_constraint_department_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT fk_constraint_department_id FOREIGN KEY (department_id) REFERENCES public.department(department_id) ON UPDATE CASCADE ON DELETE CASCADE;
 V   ALTER TABLE ONLY public.employee_records DROP CONSTRAINT fk_constraint_department_id;
       public          postgres    false    219    4756    223            �           2606    16658 '   employee_records fk_constraint_job_post    FK CONSTRAINT     �   ALTER TABLE ONLY public.employee_records
    ADD CONSTRAINT fk_constraint_job_post FOREIGN KEY (job_post_id) REFERENCES public.job_post(job_post_id) ON UPDATE CASCADE ON DELETE CASCADE;
 Q   ALTER TABLE ONLY public.employee_records DROP CONSTRAINT fk_constraint_job_post;
       public          postgres    false    223    227    4768            a   �   x�U��
�0Eg�cL�ԏ1C��5kј�!�
N�?-��.�E��W	��D������,a�R_i�U?$+��K�)�-�1�Z��4��I�}�xΩ��Y��7���G���Bf�����ΓE��A�����w��: �6�      b   �   x�=�]N�0���S�	P+	�{��]�$�e�ӓ�ă?Y3��i|#�j1���*��/�&sސP�Pn�h�Ԇ�i����"�7-�`-���+B����}��n��6In�y�#=���K�XLyݮ�������~?���3���i%���a1�!KgF/1�}a~�g���$����/�0� LCQ2      d   ?   x�3�tN,J����O��2�.-JO-��2�L�M2�+rSS�L9SR�JJ�R�b���� ~�      f   (   x�36�44�26�44��26�4�26	i 'F��� j�_      g   �   x�m��n�0E�������X��q��AB���MK�fV#��}����Mi��F��w��8`��p�=U�9�
a !�f��>�h|(�c0v[T<P*���@?�GL�|ܿ���\� I��`$��� k$�\XN��'ˢ��a���P�Ukk�˨�_R���H!u�˥��&׺�'��������>�m�]�����w�#7��ַ�+^���1���r7      i   ?   x�M��� ���0=����u~�Y�R8��RL!T(�*󀋞���\������.އ�      j   �   x�E�;�@k�{������!(i���u�J����|
�F3�6p�,�S��6H�H[heP�b҇�l.H;��p5�U��w���3w�.1e���%��k��� �C�I��V0����8��l?��@�B0�      l   L   x�3��J�K�,H,..�/J115�L�2����ȃ���M83Rss9AL��?.CC�Ĕ��<(Y����� 4G]      m   �   x�E�K
� ���a��H;�Ĝ�E�Z�3��'�X�|�#|O�\f�s�-X��8����{n!�V{xRZ0A<j�O��$X�;�^�>~���R�{��Iï�T���H4A���)){[�"��7      n   \   x�]�;�0@���a"��ah ۘK�:��i��8�װ�ڕ��K.�Q�SwGtLN����N��7�V�Mbbh���?%ʓ+�*�GD~'�{      o   �   x�E�A�0��W�6P�/�H�I)�}m8�'{=�ۂk��g��w;�\�kp>9�o{ .����8����	sv�Ve�&�c��%D.q)����ߐHcԊ5'�Xf�l!� �����{7l��"),O�㽻e�S&5C��4�����#�>:7>#=nD���5i      q      x������ � �      r   �   x�-�A��0D��)|T�-�waHH#�5������fFO��� >Wೖ�9zE��\�s�{�d���n�F��&��RH5����#������Y@X�+�#�h��'�QcG��N�:w�an�K���- M,`�W�U��o(��Z�{�D
M�v�������g[�i���ۂ�"~ �8?�      t   �  x�eS˲� ]�_�L�Jbֳ���b��i�r+a�~@�J4Uj��݀��CY�<��҆�D)������� 	
�6��h� �3��!a���rvH� W�=È|���vAW��a�I�H2{kvusl�P�:�f����u�R(� ��$�S��i�4�κ4�t/�������<r��3���,N0\F�VK�^�(�,�-/$��P��A��6����«����_�����J��8-��m��n�
@	��"8�����=�������	0��75�:��S�_[�>p!�pr��쮅8�GӐ\�A�<位�O�m�����{u�">�� �������@7S�&oi�]g-H�9M��Oem���ci�E���Ar���=������k�gw6���8��d�KT�:��9]t=��vm�������w!�      v   �   x�]��n�0�����%yK�v)��C�.rd8j,+��}��IQ�������Ӑ�^�i����!�|S#,��|�S�/�q,�Rؗ�iR�3�,�d�����˷��0��v����V�.�o3��+E�r��b?�q��]�6Ax�E��g�fx�s�Z�n�܆�.��u
i_%��ٮ�!=L�xA����+�%¡�-/:��WVZ/�ʕ�CTU�ɡs�      x   K   x�3�44�L*�L�.��*H�2�44��L�I,..����52�4671�74�0 +��4�'m	2� �D ��=... �$�      e   K   x�-���0��K1/�mzI�ub�$qh�c�	?+��$ow�$@�hʦy���ӊvߔ�^�+��<�ϻ���"      c   \   x�U��	�0����.��*I����a+j�C>��!������B�i�����W�,�9X��7z���Wz�*�/�_v""n�ffl �      w   +   x��44�4�24��4�&\@�����1����	����� ��     