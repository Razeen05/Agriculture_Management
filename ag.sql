PGDMP                       {            ag    16.1    16.1 ?    1           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            2           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            3           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            4           1262    16554    ag    DATABASE     u   CREATE DATABASE ag WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_India.1252';
    DROP DATABASE ag;
                postgres    false            �            1255    16840    log_profile_change()    FUNCTION     �  CREATE FUNCTION public.log_profile_change() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'UPDATE' THEN
        -- Check if the field you are interested in has changed
        IF NEW.name <> OLD.name THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'name', OLD.name, NEW.name);
        END IF;
        
        IF NEW.email <> OLD.email THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'email', OLD.email, NEW.email);
        END IF;
		 IF NEW.password <> OLD.password THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'password', OLD.password, NEW.password);
        END IF;
        
        
        -- Repeat the above for other fields

        RETURN NEW;
    END IF;
    RETURN NULL;
END;
$$;
 +   DROP FUNCTION public.log_profile_change();
       public          postgres    false            �            1255    16837    log_profile_changes()    FUNCTION     �  CREATE FUNCTION public.log_profile_changes() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'UPDATE' THEN
        -- Check if the field you are interested in has changed
        IF NEW.name <> OLD.name THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'name', OLD.name, NEW.name);
        END IF;
        
        IF NEW.email <> OLD.email THEN
            INSERT INTO profile_log (user_id, field_name, old_value, new_value)
            VALUES (NEW.id, 'email', OLD.email, NEW.email);
        END IF;
        
        -- Repeat the above for other fields

        RETURN NEW;
    END IF;
    RETURN NULL;
END;
$$;
 ,   DROP FUNCTION public.log_profile_changes();
       public          postgres    false            �            1259    16704    buyer    TABLE       CREATE TABLE public.buyer (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    mobile_number character varying(15) NOT NULL,
    place character varying(255) NOT NULL
);
    DROP TABLE public.buyer;
       public         heap    postgres    false            �            1259    16703    buyer_id_seq    SEQUENCE     �   CREATE SEQUENCE public.buyer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.buyer_id_seq;
       public          postgres    false    218            5           0    0    buyer_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.buyer_id_seq OWNED BY public.buyer.id;
          public          postgres    false    217            �            1259    16730    cart    TABLE       CREATE TABLE public.cart (
    id integer NOT NULL,
    buyer_id integer NOT NULL,
    product_id integer NOT NULL,
    quantity integer NOT NULL,
    total_price numeric(10,2) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.cart;
       public         heap    postgres    false            �            1259    16729    cart_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cart_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.cart_id_seq;
       public          postgres    false    222            6           0    0    cart_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.cart_id_seq OWNED BY public.cart.id;
          public          postgres    false    221            �            1259    16791    checkout    TABLE       CREATE TABLE public.checkout (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    number character varying(20) NOT NULL,
    email character varying(255) NOT NULL,
    payment_method character varying(50) NOT NULL,
    door_no character varying(50) NOT NULL,
    street character varying(255) NOT NULL,
    city character varying(100) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    buyer_id integer,
    product_ids integer[],
    quantities integer[],
    total_price integer
);
    DROP TABLE public.checkout;
       public         heap    postgres    false            �            1259    16790    checkout_id_seq    SEQUENCE     �   CREATE SEQUENCE public.checkout_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.checkout_id_seq;
       public          postgres    false    224            7           0    0    checkout_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.checkout_id_seq OWNED BY public.checkout.id;
          public          postgres    false    223            �            1259    16808    contact_form    TABLE     �   CREATE TABLE public.contact_form (
    cid integer NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    number character varying(15) NOT NULL,
    message text NOT NULL,
    id integer
);
     DROP TABLE public.contact_form;
       public         heap    postgres    false            �            1259    16807    contact_form_cid_seq    SEQUENCE     �   CREATE SEQUENCE public.contact_form_cid_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.contact_form_cid_seq;
       public          postgres    false    226            8           0    0    contact_form_cid_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.contact_form_cid_seq OWNED BY public.contact_form.cid;
          public          postgres    false    225            �            1259    16693    farmer    TABLE       CREATE TABLE public.farmer (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    mobile_number character varying(15) NOT NULL,
    place character varying(255) NOT NULL,
    email character varying(255) NOT NULL
);
    DROP TABLE public.farmer;
       public         heap    postgres    false            �            1259    16692    farmer_id_seq    SEQUENCE     �   CREATE SEQUENCE public.farmer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.farmer_id_seq;
       public          postgres    false    216            9           0    0    farmer_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.farmer_id_seq OWNED BY public.farmer.id;
          public          postgres    false    215            �            1259    16715    product    TABLE     �   CREATE TABLE public.product (
    id integer NOT NULL,
    imagepath character varying(255),
    price numeric(10,2) NOT NULL,
    name character varying(255) NOT NULL,
    fid integer NOT NULL
);
    DROP TABLE public.product;
       public         heap    postgres    false            �            1259    16714    product_id_seq    SEQUENCE     �   CREATE SEQUENCE public.product_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.product_id_seq;
       public          postgres    false    220            :           0    0    product_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.product_id_seq OWNED BY public.product.id;
          public          postgres    false    219            �            1259    16828    profile_log    TABLE       CREATE TABLE public.profile_log (
    id integer NOT NULL,
    user_id integer,
    field_name character varying(255),
    old_value character varying(255),
    new_value character varying(255),
    change_time timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.profile_log;
       public         heap    postgres    false            �            1259    16827    profile_log_id_seq    SEQUENCE     �   CREATE SEQUENCE public.profile_log_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.profile_log_id_seq;
       public          postgres    false    228            ;           0    0    profile_log_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.profile_log_id_seq OWNED BY public.profile_log.id;
          public          postgres    false    227            q           2604    16707    buyer id    DEFAULT     d   ALTER TABLE ONLY public.buyer ALTER COLUMN id SET DEFAULT nextval('public.buyer_id_seq'::regclass);
 7   ALTER TABLE public.buyer ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    217    218    218            s           2604    16733    cart id    DEFAULT     b   ALTER TABLE ONLY public.cart ALTER COLUMN id SET DEFAULT nextval('public.cart_id_seq'::regclass);
 6   ALTER TABLE public.cart ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    222    221    222            u           2604    16794    checkout id    DEFAULT     j   ALTER TABLE ONLY public.checkout ALTER COLUMN id SET DEFAULT nextval('public.checkout_id_seq'::regclass);
 :   ALTER TABLE public.checkout ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    224    223    224            w           2604    16811    contact_form cid    DEFAULT     t   ALTER TABLE ONLY public.contact_form ALTER COLUMN cid SET DEFAULT nextval('public.contact_form_cid_seq'::regclass);
 ?   ALTER TABLE public.contact_form ALTER COLUMN cid DROP DEFAULT;
       public          postgres    false    226    225    226            p           2604    16696 	   farmer id    DEFAULT     f   ALTER TABLE ONLY public.farmer ALTER COLUMN id SET DEFAULT nextval('public.farmer_id_seq'::regclass);
 8   ALTER TABLE public.farmer ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    216    216            r           2604    16718 
   product id    DEFAULT     h   ALTER TABLE ONLY public.product ALTER COLUMN id SET DEFAULT nextval('public.product_id_seq'::regclass);
 9   ALTER TABLE public.product ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    220    220            x           2604    16831    profile_log id    DEFAULT     p   ALTER TABLE ONLY public.profile_log ALTER COLUMN id SET DEFAULT nextval('public.profile_log_id_seq'::regclass);
 =   ALTER TABLE public.profile_log ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    227    228    228            $          0    16704    buyer 
   TABLE DATA           P   COPY public.buyer (id, name, password, email, mobile_number, place) FROM stdin;
    public          postgres    false    218   �M       (          0    16730    cart 
   TABLE DATA           [   COPY public.cart (id, buyer_id, product_id, quantity, total_price, created_at) FROM stdin;
    public          postgres    false    222   WN       *          0    16791    checkout 
   TABLE DATA           �   COPY public.checkout (id, name, number, email, payment_method, door_no, street, city, created_at, buyer_id, product_ids, quantities, total_price) FROM stdin;
    public          postgres    false    224   �N       ,          0    16808    contact_form 
   TABLE DATA           M   COPY public.contact_form (cid, name, email, number, message, id) FROM stdin;
    public          postgres    false    226   9P       "          0    16693    farmer 
   TABLE DATA           Q   COPY public.farmer (id, name, password, mobile_number, place, email) FROM stdin;
    public          postgres    false    216   �P       &          0    16715    product 
   TABLE DATA           B   COPY public.product (id, imagepath, price, name, fid) FROM stdin;
    public          postgres    false    220   TQ       .          0    16828    profile_log 
   TABLE DATA           a   COPY public.profile_log (id, user_id, field_name, old_value, new_value, change_time) FROM stdin;
    public          postgres    false    228   AR       <           0    0    buyer_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.buyer_id_seq', 3, true);
          public          postgres    false    217            =           0    0    cart_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.cart_id_seq', 33, true);
          public          postgres    false    221            >           0    0    checkout_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.checkout_id_seq', 13, true);
          public          postgres    false    223            ?           0    0    contact_form_cid_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.contact_form_cid_seq', 3, true);
          public          postgres    false    225            @           0    0    farmer_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.farmer_id_seq', 18, true);
          public          postgres    false    215            A           0    0    product_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.product_id_seq', 14, true);
          public          postgres    false    219            B           0    0    profile_log_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.profile_log_id_seq', 5, true);
          public          postgres    false    227                       2606    16713    buyer buyer_email_key 
   CONSTRAINT     Q   ALTER TABLE ONLY public.buyer
    ADD CONSTRAINT buyer_email_key UNIQUE (email);
 ?   ALTER TABLE ONLY public.buyer DROP CONSTRAINT buyer_email_key;
       public            postgres    false    218            �           2606    16711    buyer buyer_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.buyer
    ADD CONSTRAINT buyer_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.buyer DROP CONSTRAINT buyer_pkey;
       public            postgres    false    218            �           2606    16736    cart cart_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.cart
    ADD CONSTRAINT cart_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.cart DROP CONSTRAINT cart_pkey;
       public            postgres    false    222            �           2606    16799    checkout checkout_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.checkout
    ADD CONSTRAINT checkout_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.checkout DROP CONSTRAINT checkout_pkey;
       public            postgres    false    224            �           2606    16815    contact_form contact_form_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.contact_form
    ADD CONSTRAINT contact_form_pkey PRIMARY KEY (cid);
 H   ALTER TABLE ONLY public.contact_form DROP CONSTRAINT contact_form_pkey;
       public            postgres    false    226            {           2606    16702    farmer farmer_email_key 
   CONSTRAINT     S   ALTER TABLE ONLY public.farmer
    ADD CONSTRAINT farmer_email_key UNIQUE (email);
 A   ALTER TABLE ONLY public.farmer DROP CONSTRAINT farmer_email_key;
       public            postgres    false    216            }           2606    16700    farmer farmer_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.farmer
    ADD CONSTRAINT farmer_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.farmer DROP CONSTRAINT farmer_pkey;
       public            postgres    false    216            �           2606    16722    product product_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.product
    ADD CONSTRAINT product_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.product DROP CONSTRAINT product_pkey;
       public            postgres    false    220            �           2606    16836    profile_log profile_log_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.profile_log
    ADD CONSTRAINT profile_log_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.profile_log DROP CONSTRAINT profile_log_pkey;
       public            postgres    false    228            �           2620    16841    buyer profile_change_trigger    TRIGGER     ~   CREATE TRIGGER profile_change_trigger AFTER UPDATE ON public.buyer FOR EACH ROW EXECUTE FUNCTION public.log_profile_change();
 5   DROP TRIGGER profile_change_trigger ON public.buyer;
       public          postgres    false    218    230            �           2620    16842    farmer profile_change_trigger    TRIGGER        CREATE TRIGGER profile_change_trigger AFTER UPDATE ON public.farmer FOR EACH ROW EXECUTE FUNCTION public.log_profile_change();
 6   DROP TRIGGER profile_change_trigger ON public.farmer;
       public          postgres    false    216    230            �           2606    16737    cart cart_buyer_id_fkey    FK CONSTRAINT     w   ALTER TABLE ONLY public.cart
    ADD CONSTRAINT cart_buyer_id_fkey FOREIGN KEY (buyer_id) REFERENCES public.buyer(id);
 A   ALTER TABLE ONLY public.cart DROP CONSTRAINT cart_buyer_id_fkey;
       public          postgres    false    4737    222    218            �           2606    16742    cart cart_product_id_fkey    FK CONSTRAINT     }   ALTER TABLE ONLY public.cart
    ADD CONSTRAINT cart_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.product(id);
 C   ALTER TABLE ONLY public.cart DROP CONSTRAINT cart_product_id_fkey;
       public          postgres    false    4739    222    220            �           2606    16800    checkout checkout_buyer_id_fkey    FK CONSTRAINT        ALTER TABLE ONLY public.checkout
    ADD CONSTRAINT checkout_buyer_id_fkey FOREIGN KEY (buyer_id) REFERENCES public.buyer(id);
 I   ALTER TABLE ONLY public.checkout DROP CONSTRAINT checkout_buyer_id_fkey;
       public          postgres    false    218    224    4737            �           2606    16723    product product_fid_fkey    FK CONSTRAINT     t   ALTER TABLE ONLY public.product
    ADD CONSTRAINT product_fid_fkey FOREIGN KEY (fid) REFERENCES public.farmer(id);
 B   ALTER TABLE ONLY public.product DROP CONSTRAINT product_fid_fkey;
       public          postgres    false    4733    220    216            $   Y   x�3�L�/H��44261��2tH�M���K�υ��[Xp�d��攥�drCtB�9��	�1�,N,�HM-΀���ƪ�E_� �o.�      (   C   x�u�A�@�7�����
rZ�_G.2��JJ�d���\�En�Y����^?r����T���      *     x��ӽj�@���)� �p�J�*i�2�xWd�we��N�w�h�bnVBBH��9�!x8��E͇�>|?���v�'ؕ��ql��qx�W ��0=�����Oϧ�2 #��r˒	�%G~]��@�L�4�%]I��d��K}�+I7�B��P1�=���X��^o+�o i���ث����2��/��N���^@��x{R(�:����LW�n�ZȚ�a�6ʕ$� �|5�P�w�b����ڜ��pnwe�3|,��0�_�Sߟ��翘���CagB��X���"L�gߏk�P��C��T^���m��,�����3�"٬��{5��8��`�KJ2s��X}��"_��MQ��y�Ue�e,�\b��X�P>6�\�4��ۄ�      ,   >   x�3���H���vH�M���K���4426153��0�,.-H-�4�2"���̘Ì�b���� � �      "   �   x���M�0���0��Ɲ^��K7�4�R~҈Oo#GLФ�t��Hh݃�rT�,Jڥp�aꍿo������'��}7�G��<�C=��oG\���Z9(����
�	�#(i�*7؊a��x?,��8��
�#4)�R.�iV�m��ߝ����
�׾ZЗ姓��WX���6|�s"�x �s��      &   �   x����N�@D��W��ۻ�6��	�.n�H����BB)�:��#�@P��I�[���Dp�]�@�B�S��=�:�Y���Y�Ig�ɑ�Ѣ`Q �|�WyֻC�+x��j7��S!$fò!S9'��ip�C�%3�1���Xk֙��.� �sn�*W�-Sp�n��;���zb}���-X`�$�4���M%t)��ZF����s�8���D�w�m�      .   �   x�}�A
�0EדSx����dԬ<����Hl+�����������OPr^�@H�9�Я��l��*�jh��>�/Pv�g���C�f,���j��j�B8���	�������c����_c��q:�#��wo���5�< �MD�     