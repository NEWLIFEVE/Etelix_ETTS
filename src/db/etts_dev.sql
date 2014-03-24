--
-- PostgreSQL database dump
--

-- Dumped from database version 9.2.4
-- Dumped by pg_dump version 9.2.4
-- Started on 2014-03-21 18:23:26

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 214 (class 3079 OID 11727)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2227 (class 0 OID 0)
-- Dependencies: 214
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 215 (class 3079 OID 8669639)
-- Name: dblink; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS dblink WITH SCHEMA public;


--
-- TOC entry 2228 (class 0 OID 0)
-- Dependencies: 215
-- Name: EXTENSION dblink; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION dblink IS 'connect to other PostgreSQL databases from within a database';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 168 (class 1259 OID 8454186)
-- Name: file; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE file (
    id integer NOT NULL,
    id_ticket integer NOT NULL,
    saved_name character varying(100) NOT NULL,
    real_name character varying(100) NOT NULL,
    size double precision NOT NULL,
    rute character varying(200) NOT NULL,
    id_description_ticket integer
);


ALTER TABLE public.file OWNER TO postgres;

--
-- TOC entry 169 (class 1259 OID 8454189)
-- Name: archivos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE archivos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.archivos_id_seq OWNER TO postgres;

--
-- TOC entry 2229 (class 0 OID 0)
-- Dependencies: 169
-- Name: archivos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE archivos_id_seq OWNED BY file.id;


--
-- TOC entry 170 (class 1259 OID 8454191)
-- Name: class; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE class (
    id integer NOT NULL,
    name character varying(40) NOT NULL
);


ALTER TABLE public.class OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 8454194)
-- Name: clase_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE clase_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.clase_id_seq OWNER TO postgres;

--
-- TOC entry 2230 (class 0 OID 0)
-- Dependencies: 171
-- Name: clase_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE clase_id_seq OWNED BY class.id;


--
-- TOC entry 174 (class 1259 OID 8454204)
-- Name: country; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE country (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.country OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 8470854)
-- Name: cruge_authassignment; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_authassignment (
    userid integer NOT NULL,
    bizrule text,
    data text,
    itemname character varying(64) NOT NULL
);


ALTER TABLE public.cruge_authassignment OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 8470846)
-- Name: cruge_authitem; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_authitem (
    name character varying(64) NOT NULL,
    type integer NOT NULL,
    description text,
    bizrule text,
    data text
);


ALTER TABLE public.cruge_authitem OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 8470872)
-- Name: cruge_authitemchild; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_authitemchild (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE public.cruge_authitemchild OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 8470809)
-- Name: cruge_field; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_field (
    idfield integer NOT NULL,
    fieldname character varying(20) NOT NULL,
    longname character varying(50),
    "position" integer DEFAULT 0,
    required integer DEFAULT 0,
    fieldtype integer DEFAULT 0,
    fieldsize integer DEFAULT 20,
    maxlength integer DEFAULT 45,
    showinreports integer DEFAULT 0,
    useregexp character varying(512),
    useregexpmsg character varying(512),
    predetvalue character varying(4096)
);


ALTER TABLE public.cruge_field OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 8470807)
-- Name: cruge_field_idfield_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cruge_field_idfield_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cruge_field_idfield_seq OWNER TO postgres;

--
-- TOC entry 2231 (class 0 OID 0)
-- Dependencies: 200
-- Name: cruge_field_idfield_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_field_idfield_seq OWNED BY cruge_field.idfield;


--
-- TOC entry 203 (class 1259 OID 8470826)
-- Name: cruge_fieldvalue; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_fieldvalue (
    idfieldvalue integer NOT NULL,
    iduser integer NOT NULL,
    idfield integer NOT NULL,
    value character varying(4096)
);


ALTER TABLE public.cruge_fieldvalue OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 8470824)
-- Name: cruge_fieldvalue_idfieldvalue_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cruge_fieldvalue_idfieldvalue_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cruge_fieldvalue_idfieldvalue_seq OWNER TO postgres;

--
-- TOC entry 2232 (class 0 OID 0)
-- Dependencies: 202
-- Name: cruge_fieldvalue_idfieldvalue_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_fieldvalue_idfieldvalue_seq OWNED BY cruge_fieldvalue.idfieldvalue;


--
-- TOC entry 197 (class 1259 OID 8470788)
-- Name: cruge_session; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_session (
    idsession integer NOT NULL,
    iduser integer NOT NULL,
    created bigint,
    expire bigint,
    status integer DEFAULT 0,
    ipaddress character varying(45),
    usagecount integer DEFAULT 0,
    lastusage bigint,
    logoutdate bigint,
    ipaddressout character varying(45)
);


ALTER TABLE public.cruge_session OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 8470786)
-- Name: cruge_session_idsession_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cruge_session_idsession_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cruge_session_idsession_seq OWNER TO postgres;

--
-- TOC entry 2233 (class 0 OID 0)
-- Dependencies: 196
-- Name: cruge_session_idsession_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_session_idsession_seq OWNED BY cruge_session.idsession;


--
-- TOC entry 195 (class 1259 OID 8470765)
-- Name: cruge_system; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_system (
    idsystem integer NOT NULL,
    name character varying(45),
    largename character varying(45),
    sessionmaxdurationmins integer DEFAULT 30,
    sessionmaxsameipconnections integer DEFAULT 10,
    sessionreusesessions integer DEFAULT 1,
    sessionmaxsessionsperday integer DEFAULT (-1),
    sessionmaxsessionsperuser integer DEFAULT (-1),
    systemnonewsessions integer DEFAULT 0,
    systemdown integer DEFAULT 0,
    registerusingcaptcha integer DEFAULT 0,
    registerusingterms integer DEFAULT 0,
    terms character varying(4096),
    registerusingactivation integer DEFAULT 1,
    defaultroleforregistration character varying(64),
    registerusingtermslabel character varying(100),
    registrationonlogin integer DEFAULT 1
);


ALTER TABLE public.cruge_system OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 8470763)
-- Name: cruge_system_idsystem_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cruge_system_idsystem_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cruge_system_idsystem_seq OWNER TO postgres;

--
-- TOC entry 2234 (class 0 OID 0)
-- Dependencies: 194
-- Name: cruge_system_idsystem_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_system_idsystem_seq OWNED BY cruge_system.idsystem;


--
-- TOC entry 199 (class 1259 OID 8470798)
-- Name: cruge_user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_user (
    iduser integer NOT NULL,
    regdate bigint,
    actdate bigint,
    logondate bigint,
    username character varying(64),
    email character varying(45),
    password character varying(64),
    authkey character varying(100),
    state integer DEFAULT 0,
    totalsessioncounter integer DEFAULT 0,
    currentsessioncounter integer DEFAULT 0,
    id_carrier integer
);


ALTER TABLE public.cruge_user OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 8470796)
-- Name: cruge_user_iduser_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cruge_user_iduser_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cruge_user_iduser_seq OWNER TO postgres;

--
-- TOC entry 2235 (class 0 OID 0)
-- Dependencies: 198
-- Name: cruge_user_iduser_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_user_iduser_seq OWNED BY cruge_user.iduser;


--
-- TOC entry 172 (class 1259 OID 8454196)
-- Name: description_ticket; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE description_ticket (
    id integer NOT NULL,
    id_ticket integer NOT NULL,
    description text NOT NULL,
    date date NOT NULL,
    hour time without time zone,
    id_speech integer,
    id_user integer,
    read_carrier integer DEFAULT 0,
    read_internal integer DEFAULT 0,
    response_by integer DEFAULT 0
);


ALTER TABLE public.description_ticket OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 8454202)
-- Name: descripcion_ticket_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE descripcion_ticket_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.descripcion_ticket_id_seq OWNER TO postgres;

--
-- TOC entry 2236 (class 0 OID 0)
-- Dependencies: 173
-- Name: descripcion_ticket_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE descripcion_ticket_id_seq OWNED BY description_ticket.id;


--
-- TOC entry 175 (class 1259 OID 8454207)
-- Name: destinos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE destinos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.destinos_id_seq OWNER TO postgres;

--
-- TOC entry 2237 (class 0 OID 0)
-- Dependencies: 175
-- Name: destinos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE destinos_id_seq OWNED BY country.id;


--
-- TOC entry 176 (class 1259 OID 8454209)
-- Name: failure; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE failure (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.failure OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 8454212)
-- Name: fallas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE fallas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.fallas_id_seq OWNER TO postgres;

--
-- TOC entry 2238 (class 0 OID 0)
-- Dependencies: 177
-- Name: fallas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE fallas_id_seq OWNED BY failure.id;


SET default_with_oids = true;

--
-- TOC entry 191 (class 1259 OID 8463904)
-- Name: gmt; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE gmt (
    id integer NOT NULL,
    name character varying(150),
    description character varying(100),
    relative character varying(50)
);


ALTER TABLE public.gmt OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 8463902)
-- Name: gmt_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE gmt_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gmt_id_seq OWNER TO postgres;

--
-- TOC entry 2239 (class 0 OID 0)
-- Dependencies: 190
-- Name: gmt_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE gmt_id_seq OWNED BY gmt.id;


SET default_with_oids = false;

--
-- TOC entry 211 (class 1259 OID 14723845)
-- Name: language; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE language (
    id integer NOT NULL,
    name character varying(50) NOT NULL
);


ALTER TABLE public.language OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 14723843)
-- Name: language_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE language_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.language_id_seq OWNER TO postgres;

--
-- TOC entry 2240 (class 0 OID 0)
-- Dependencies: 210
-- Name: language_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE language_id_seq OWNED BY language.id;


--
-- TOC entry 178 (class 1259 OID 8454214)
-- Name: mail; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mail (
    id integer NOT NULL,
    mail character varying(100) NOT NULL
);


ALTER TABLE public.mail OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 8454217)
-- Name: mail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mail_id_seq OWNER TO postgres;

--
-- TOC entry 2241 (class 0 OID 0)
-- Dependencies: 179
-- Name: mail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_id_seq OWNED BY mail.id;


--
-- TOC entry 180 (class 1259 OID 8454219)
-- Name: mail_ticket; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mail_ticket (
    id_mail_user integer NOT NULL,
    id_ticket integer NOT NULL,
    id integer NOT NULL,
    id_type_mailing integer NOT NULL
);


ALTER TABLE public.mail_ticket OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 8456010)
-- Name: mail_tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mail_tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mail_tickets_id_seq OWNER TO postgres;

--
-- TOC entry 2242 (class 0 OID 0)
-- Dependencies: 189
-- Name: mail_tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_tickets_id_seq OWNED BY mail_ticket.id;


SET default_with_oids = true;

--
-- TOC entry 193 (class 1259 OID 8465275)
-- Name: mail_user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mail_user (
    id integer NOT NULL,
    id_user integer NOT NULL,
    id_mail integer NOT NULL,
    status integer,
    assign_by integer
);


ALTER TABLE public.mail_user OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 8465273)
-- Name: mail_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mail_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mail_user_id_seq OWNER TO postgres;

--
-- TOC entry 2243 (class 0 OID 0)
-- Dependencies: 192
-- Name: mail_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_user_id_seq OWNED BY mail_user.id;


--
-- TOC entry 181 (class 1259 OID 8454222)
-- Name: speech; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE speech (
    id integer NOT NULL,
    speech text NOT NULL,
    code character varying(50),
    title character varying(50),
    id_language integer
);


ALTER TABLE public.speech OWNER TO postgres;

--
-- TOC entry 2244 (class 0 OID 0)
-- Dependencies: 181
-- Name: TABLE speech; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE speech IS 'respuestas rapidas predeterminadas';


--
-- TOC entry 182 (class 1259 OID 8454225)
-- Name: respuesta_rapida_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE respuesta_rapida_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.respuesta_rapida_id_seq OWNER TO postgres;

--
-- TOC entry 2245 (class 0 OID 0)
-- Dependencies: 182
-- Name: respuesta_rapida_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE respuesta_rapida_id_seq OWNED BY speech.id;


SET default_with_oids = false;

--
-- TOC entry 183 (class 1259 OID 8454240)
-- Name: status; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE status (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    color character varying(50)
);


ALTER TABLE public.status OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 8454243)
-- Name: statu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE statu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.statu_id_seq OWNER TO postgres;

--
-- TOC entry 2246 (class 0 OID 0)
-- Dependencies: 184
-- Name: statu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE statu_id_seq OWNED BY status.id;


--
-- TOC entry 185 (class 1259 OID 8454245)
-- Name: tested_number; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tested_number (
    id integer NOT NULL,
    id_ticket integer NOT NULL,
    id_country integer NOT NULL,
    numero integer NOT NULL,
    date date NOT NULL,
    hour time without time zone
);


ALTER TABLE public.tested_number OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 8454248)
-- Name: tested_numbers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tested_numbers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tested_numbers_id_seq OWNER TO postgres;

--
-- TOC entry 2247 (class 0 OID 0)
-- Dependencies: 186
-- Name: tested_numbers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tested_numbers_id_seq OWNED BY tested_number.id;


--
-- TOC entry 187 (class 1259 OID 8454250)
-- Name: ticket; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ticket (
    id integer NOT NULL,
    id_failure integer NOT NULL,
    id_status integer NOT NULL,
    origination_ip character varying(64),
    destination_ip character varying(64),
    date date NOT NULL,
    machine_ip character varying(64) NOT NULL,
    hour time without time zone,
    id_gmt integer,
    ticket_number character varying(50),
    prefix integer,
    id_user integer,
    option_open character varying(50)
);


ALTER TABLE public.ticket OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 209 (class 1259 OID 8773491)
-- Name: ticket_relation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ticket_relation (
    id integer NOT NULL,
    id_ticket_father integer NOT NULL,
    id_ticket_son integer NOT NULL
);


ALTER TABLE public.ticket_relation OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 8773489)
-- Name: ticket_relation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ticket_relation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ticket_relation_id_seq OWNER TO postgres;

--
-- TOC entry 2248 (class 0 OID 0)
-- Dependencies: 208
-- Name: ticket_relation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ticket_relation_id_seq OWNED BY ticket_relation.id;


--
-- TOC entry 188 (class 1259 OID 8454253)
-- Name: tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tickets_id_seq OWNER TO postgres;

--
-- TOC entry 2249 (class 0 OID 0)
-- Dependencies: 188
-- Name: tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tickets_id_seq OWNED BY ticket.id;


SET default_with_oids = false;

--
-- TOC entry 213 (class 1259 OID 14728363)
-- Name: type_mailing; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE type_mailing (
    id integer NOT NULL,
    name character varying(50)
);


ALTER TABLE public.type_mailing OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 14728361)
-- Name: type_mailing_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE type_mailing_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.type_mailing_id_seq OWNER TO postgres;

--
-- TOC entry 2250 (class 0 OID 0)
-- Dependencies: 212
-- Name: type_mailing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE type_mailing_id_seq OWNED BY type_mailing.id;


--
-- TOC entry 2101 (class 2604 OID 8454261)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY class ALTER COLUMN id SET DEFAULT nextval('clase_id_seq'::regclass);


--
-- TOC entry 2106 (class 2604 OID 8454263)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('destinos_id_seq'::regclass);


--
-- TOC entry 2135 (class 2604 OID 8470812)
-- Name: idfield; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_field ALTER COLUMN idfield SET DEFAULT nextval('cruge_field_idfield_seq'::regclass);


--
-- TOC entry 2142 (class 2604 OID 8470829)
-- Name: idfieldvalue; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue ALTER COLUMN idfieldvalue SET DEFAULT nextval('cruge_fieldvalue_idfieldvalue_seq'::regclass);


--
-- TOC entry 2128 (class 2604 OID 8470791)
-- Name: idsession; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_session ALTER COLUMN idsession SET DEFAULT nextval('cruge_session_idsession_seq'::regclass);


--
-- TOC entry 2116 (class 2604 OID 8470768)
-- Name: idsystem; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_system ALTER COLUMN idsystem SET DEFAULT nextval('cruge_system_idsystem_seq'::regclass);


--
-- TOC entry 2131 (class 2604 OID 8470801)
-- Name: iduser; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_user ALTER COLUMN iduser SET DEFAULT nextval('cruge_user_iduser_seq'::regclass);


--
-- TOC entry 2102 (class 2604 OID 8454262)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket ALTER COLUMN id SET DEFAULT nextval('descripcion_ticket_id_seq'::regclass);


--
-- TOC entry 2107 (class 2604 OID 8454264)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY failure ALTER COLUMN id SET DEFAULT nextval('fallas_id_seq'::regclass);


--
-- TOC entry 2100 (class 2604 OID 8454260)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file ALTER COLUMN id SET DEFAULT nextval('archivos_id_seq'::regclass);


--
-- TOC entry 2114 (class 2604 OID 8463907)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY gmt ALTER COLUMN id SET DEFAULT nextval('gmt_id_seq'::regclass);


--
-- TOC entry 2144 (class 2604 OID 14723848)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY language ALTER COLUMN id SET DEFAULT nextval('language_id_seq'::regclass);


--
-- TOC entry 2108 (class 2604 OID 8454265)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail ALTER COLUMN id SET DEFAULT nextval('mail_id_seq'::regclass);


--
-- TOC entry 2109 (class 2604 OID 8456012)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket ALTER COLUMN id SET DEFAULT nextval('mail_tickets_id_seq'::regclass);


--
-- TOC entry 2115 (class 2604 OID 8465278)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user ALTER COLUMN id SET DEFAULT nextval('mail_user_id_seq'::regclass);


--
-- TOC entry 2110 (class 2604 OID 8454266)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speech ALTER COLUMN id SET DEFAULT nextval('respuesta_rapida_id_seq'::regclass);


--
-- TOC entry 2111 (class 2604 OID 8454269)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY status ALTER COLUMN id SET DEFAULT nextval('statu_id_seq'::regclass);


--
-- TOC entry 2112 (class 2604 OID 8454270)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number ALTER COLUMN id SET DEFAULT nextval('tested_numbers_id_seq'::regclass);


--
-- TOC entry 2113 (class 2604 OID 8454271)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket ALTER COLUMN id SET DEFAULT nextval('tickets_id_seq'::regclass);


--
-- TOC entry 2143 (class 2604 OID 8773494)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation ALTER COLUMN id SET DEFAULT nextval('ticket_relation_id_seq'::regclass);


--
-- TOC entry 2145 (class 2604 OID 14728366)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY type_mailing ALTER COLUMN id SET DEFAULT nextval('type_mailing_id_seq'::regclass);


--
-- TOC entry 2149 (class 2606 OID 8461519)
-- Name: class_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY class
    ADD CONSTRAINT class_pk PRIMARY KEY (id);


--
-- TOC entry 2153 (class 2606 OID 8461559)
-- Name: country_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pk PRIMARY KEY (id);


--
-- TOC entry 2187 (class 2606 OID 8470861)
-- Name: cruge_authassignment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT cruge_authassignment_pkey PRIMARY KEY (userid, itemname);


--
-- TOC entry 2185 (class 2606 OID 8470853)
-- Name: cruge_authitem_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authitem
    ADD CONSTRAINT cruge_authitem_pkey PRIMARY KEY (name);


--
-- TOC entry 2189 (class 2606 OID 8470876)
-- Name: cruge_authitemchild_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT cruge_authitemchild_pkey PRIMARY KEY (parent, child);


--
-- TOC entry 2181 (class 2606 OID 8470823)
-- Name: cruge_field_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_field
    ADD CONSTRAINT cruge_field_pkey PRIMARY KEY (idfield);


--
-- TOC entry 2183 (class 2606 OID 8470834)
-- Name: cruge_fieldvalue_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT cruge_fieldvalue_pkey PRIMARY KEY (idfieldvalue);


--
-- TOC entry 2177 (class 2606 OID 8470795)
-- Name: cruge_session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_session
    ADD CONSTRAINT cruge_session_pkey PRIMARY KEY (idsession);


--
-- TOC entry 2175 (class 2606 OID 8470784)
-- Name: cruge_system_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_system
    ADD CONSTRAINT cruge_system_pkey PRIMARY KEY (idsystem);


--
-- TOC entry 2179 (class 2606 OID 8470806)
-- Name: cruge_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_user
    ADD CONSTRAINT cruge_user_pkey PRIMARY KEY (iduser);


--
-- TOC entry 2151 (class 2606 OID 8465354)
-- Name: description_ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT description_ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2155 (class 2606 OID 8461595)
-- Name: failure_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY failure
    ADD CONSTRAINT failure_pk PRIMARY KEY (id);


--
-- TOC entry 2147 (class 2606 OID 8461633)
-- Name: file_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY file
    ADD CONSTRAINT file_pk PRIMARY KEY (id);


--
-- TOC entry 2171 (class 2606 OID 8463909)
-- Name: gmt_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY gmt
    ADD CONSTRAINT gmt_pk PRIMARY KEY (id);


--
-- TOC entry 2195 (class 2606 OID 14728368)
-- Name: id_type_mailing; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY type_mailing
    ADD CONSTRAINT id_type_mailing PRIMARY KEY (id);


--
-- TOC entry 2193 (class 2606 OID 14723850)
-- Name: language_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY language
    ADD CONSTRAINT language_pk PRIMARY KEY (id);


--
-- TOC entry 2157 (class 2606 OID 8461674)
-- Name: mail_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail
    ADD CONSTRAINT mail_pk PRIMARY KEY (id);


--
-- TOC entry 2161 (class 2606 OID 8461775)
-- Name: mail_ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT mail_ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2159 (class 2606 OID 8460683)
-- Name: mail_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail
    ADD CONSTRAINT mail_unique UNIQUE (mail);


--
-- TOC entry 2173 (class 2606 OID 8465280)
-- Name: mail_user_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT mail_user_pk PRIMARY KEY (id);


--
-- TOC entry 2191 (class 2606 OID 8773496)
-- Name: pk_ticket_relation; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT pk_ticket_relation PRIMARY KEY (id);


--
-- TOC entry 2163 (class 2606 OID 12396358)
-- Name: speech_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speech
    ADD CONSTRAINT speech_pk PRIMARY KEY (id);


--
-- TOC entry 2165 (class 2606 OID 8462017)
-- Name: status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT status_pk PRIMARY KEY (id);


--
-- TOC entry 2167 (class 2606 OID 8465241)
-- Name: tested_number_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT tested_number_pk PRIMARY KEY (id);


--
-- TOC entry 2169 (class 2606 OID 8465312)
-- Name: ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2205 (class 2606 OID 8465328)
-- Name: country_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT country_fk FOREIGN KEY (id_country) REFERENCES country(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2200 (class 2606 OID 12396364)
-- Name: cruge_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT cruge_user_fk FOREIGN KEY (id_user) REFERENCES cruge_user(iduser);


--
-- TOC entry 2216 (class 2606 OID 8470877)
-- Name: crugeauthitemchild_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT crugeauthitemchild_ibfk_1 FOREIGN KEY (parent) REFERENCES cruge_authitem(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2217 (class 2606 OID 8470882)
-- Name: crugeauthitemchild_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT crugeauthitemchild_ibfk_2 FOREIGN KEY (child) REFERENCES cruge_authitem(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2197 (class 2606 OID 19009105)
-- Name: description_ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file
    ADD CONSTRAINT description_ticket_fk FOREIGN KEY (id_description_ticket) REFERENCES description_ticket(id);


--
-- TOC entry 2207 (class 2606 OID 14724015)
-- Name: failure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT failure_fk FOREIGN KEY (id_failure) REFERENCES failure(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2214 (class 2606 OID 8470862)
-- Name: fk_cruge_authassignment_cruge_authitem1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT fk_cruge_authassignment_cruge_authitem1 FOREIGN KEY (itemname) REFERENCES cruge_authitem(name);


--
-- TOC entry 2215 (class 2606 OID 8470867)
-- Name: fk_cruge_authassignment_user; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT fk_cruge_authassignment_user FOREIGN KEY (userid) REFERENCES cruge_user(iduser) ON DELETE CASCADE;


--
-- TOC entry 2213 (class 2606 OID 8470841)
-- Name: fk_cruge_fieldvalue_cruge_field1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT fk_cruge_fieldvalue_cruge_field1 FOREIGN KEY (idfield) REFERENCES cruge_field(idfield) ON DELETE CASCADE;


--
-- TOC entry 2212 (class 2606 OID 8470835)
-- Name: fk_cruge_fieldvalue_cruge_user1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT fk_cruge_fieldvalue_cruge_user1 FOREIGN KEY (iduser) REFERENCES cruge_user(iduser) ON DELETE CASCADE;


--
-- TOC entry 2218 (class 2606 OID 12396003)
-- Name: fk_ticket_id_ticket_pather; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT fk_ticket_id_ticket_pather FOREIGN KEY (id_ticket_father) REFERENCES ticket(id);


--
-- TOC entry 2219 (class 2606 OID 12396008)
-- Name: fk_ticket_id_ticket_son; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT fk_ticket_id_ticket_son FOREIGN KEY (id_ticket_son) REFERENCES ticket(id);


--
-- TOC entry 2208 (class 2606 OID 14724020)
-- Name: gmt_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT gmt_fk FOREIGN KEY (id_gmt) REFERENCES gmt(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2204 (class 2606 OID 14723851)
-- Name: language_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speech
    ADD CONSTRAINT language_fk FOREIGN KEY (id_language) REFERENCES language(id);


--
-- TOC entry 2210 (class 2606 OID 8465281)
-- Name: mail_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT mail_fk FOREIGN KEY (id_mail) REFERENCES mail(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2201 (class 2606 OID 12395976)
-- Name: mail_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT mail_user_fk FOREIGN KEY (id_mail_user) REFERENCES mail_user(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2199 (class 2606 OID 12396359)
-- Name: speech_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT speech_fk FOREIGN KEY (id_speech) REFERENCES speech(id);


--
-- TOC entry 2209 (class 2606 OID 14724025)
-- Name: status_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT status_fk FOREIGN KEY (id_status) REFERENCES status(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2196 (class 2606 OID 8465313)
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2206 (class 2606 OID 8465333)
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2198 (class 2606 OID 8465355)
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2202 (class 2606 OID 12395981)
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2203 (class 2606 OID 14728369)
-- Name: type_mailing_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT type_mailing_fk FOREIGN KEY (id_type_mailing) REFERENCES type_mailing(id);


--
-- TOC entry 2211 (class 2606 OID 8502048)
-- Name: user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT user_fk FOREIGN KEY (id_user) REFERENCES cruge_user(iduser);


--
-- TOC entry 2226 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-03-21 18:23:26

--
-- PostgreSQL database dump complete
--

