--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.9
-- Dumped by pg_dump version 9.1.12
-- Started on 2014-03-21 18:26:15 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 207 (class 3079 OID 11677)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2195 (class 0 OID 0)
-- Dependencies: 207
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 208 (class 3079 OID 12643789)
-- Dependencies: 6
-- Name: dblink; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS dblink WITH SCHEMA public;


--
-- TOC entry 2196 (class 0 OID 0)
-- Dependencies: 208
-- Name: EXTENSION dblink; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION dblink IS 'connect to other PostgreSQL databases from within a database';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 162 (class 1259 OID 12643833)
-- Dependencies: 6
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
-- TOC entry 163 (class 1259 OID 12643836)
-- Dependencies: 162 6
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
-- TOC entry 2197 (class 0 OID 0)
-- Dependencies: 163
-- Name: archivos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE archivos_id_seq OWNED BY file.id;


--
-- TOC entry 164 (class 1259 OID 12643838)
-- Dependencies: 6
-- Name: class; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE class (
    id integer NOT NULL,
    name character varying(40) NOT NULL
);


ALTER TABLE public.class OWNER TO postgres;

--
-- TOC entry 165 (class 1259 OID 12643841)
-- Dependencies: 164 6
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
-- TOC entry 2198 (class 0 OID 0)
-- Dependencies: 165
-- Name: clase_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE clase_id_seq OWNED BY class.id;


--
-- TOC entry 166 (class 1259 OID 12643843)
-- Dependencies: 6
-- Name: country; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE country (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.country OWNER TO postgres;

--
-- TOC entry 167 (class 1259 OID 12643846)
-- Dependencies: 6
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
-- TOC entry 168 (class 1259 OID 12643852)
-- Dependencies: 6
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
-- TOC entry 169 (class 1259 OID 12643858)
-- Dependencies: 6
-- Name: cruge_authitemchild; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_authitemchild (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE public.cruge_authitemchild OWNER TO postgres;

--
-- TOC entry 170 (class 1259 OID 12643861)
-- Dependencies: 1970 1971 1972 1973 1974 1975 6
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
-- TOC entry 171 (class 1259 OID 12643873)
-- Dependencies: 6 170
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
-- TOC entry 2199 (class 0 OID 0)
-- Dependencies: 171
-- Name: cruge_field_idfield_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_field_idfield_seq OWNED BY cruge_field.idfield;


--
-- TOC entry 172 (class 1259 OID 12643875)
-- Dependencies: 6
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
-- TOC entry 173 (class 1259 OID 12643881)
-- Dependencies: 6 172
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
-- TOC entry 2200 (class 0 OID 0)
-- Dependencies: 173
-- Name: cruge_fieldvalue_idfieldvalue_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_fieldvalue_idfieldvalue_seq OWNED BY cruge_fieldvalue.idfieldvalue;


--
-- TOC entry 174 (class 1259 OID 12643883)
-- Dependencies: 1978 1979 6
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
-- TOC entry 175 (class 1259 OID 12643888)
-- Dependencies: 6 174
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
-- TOC entry 2201 (class 0 OID 0)
-- Dependencies: 175
-- Name: cruge_session_idsession_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_session_idsession_seq OWNED BY cruge_session.idsession;


--
-- TOC entry 176 (class 1259 OID 12643890)
-- Dependencies: 1981 1982 1983 1984 1985 1986 1987 1988 1989 1990 1991 6
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
-- TOC entry 177 (class 1259 OID 12643907)
-- Dependencies: 6 176
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
-- TOC entry 2202 (class 0 OID 0)
-- Dependencies: 177
-- Name: cruge_system_idsystem_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_system_idsystem_seq OWNED BY cruge_system.idsystem;


--
-- TOC entry 178 (class 1259 OID 12643909)
-- Dependencies: 1993 1994 1995 6
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
-- TOC entry 179 (class 1259 OID 12643915)
-- Dependencies: 178 6
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
-- TOC entry 2203 (class 0 OID 0)
-- Dependencies: 179
-- Name: cruge_user_iduser_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_user_iduser_seq OWNED BY cruge_user.iduser;


--
-- TOC entry 180 (class 1259 OID 12643917)
-- Dependencies: 1998 1999 2000 6
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
-- TOC entry 181 (class 1259 OID 12643923)
-- Dependencies: 180 6
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
-- TOC entry 2204 (class 0 OID 0)
-- Dependencies: 181
-- Name: descripcion_ticket_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE descripcion_ticket_id_seq OWNED BY description_ticket.id;


--
-- TOC entry 182 (class 1259 OID 12643925)
-- Dependencies: 6 166
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
-- TOC entry 2205 (class 0 OID 0)
-- Dependencies: 182
-- Name: destinos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE destinos_id_seq OWNED BY country.id;


--
-- TOC entry 183 (class 1259 OID 12643927)
-- Dependencies: 6
-- Name: failure; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE failure (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.failure OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 12643930)
-- Dependencies: 183 6
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
-- TOC entry 2206 (class 0 OID 0)
-- Dependencies: 184
-- Name: fallas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE fallas_id_seq OWNED BY failure.id;


SET default_with_oids = true;

--
-- TOC entry 185 (class 1259 OID 12643932)
-- Dependencies: 6
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
-- TOC entry 186 (class 1259 OID 12643935)
-- Dependencies: 6 185
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
-- TOC entry 2207 (class 0 OID 0)
-- Dependencies: 186
-- Name: gmt_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE gmt_id_seq OWNED BY gmt.id;


SET default_with_oids = false;

--
-- TOC entry 204 (class 1259 OID 12645882)
-- Dependencies: 6
-- Name: language; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE language (
    id integer NOT NULL,
    name character varying(50) NOT NULL
);


ALTER TABLE public.language OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 12645880)
-- Dependencies: 6 204
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
-- TOC entry 2208 (class 0 OID 0)
-- Dependencies: 203
-- Name: language_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE language_id_seq OWNED BY language.id;


--
-- TOC entry 187 (class 1259 OID 12643937)
-- Dependencies: 6
-- Name: mail; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mail (
    id integer NOT NULL,
    mail character varying(100) NOT NULL
);


ALTER TABLE public.mail OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 12643940)
-- Dependencies: 6 187
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
-- TOC entry 2209 (class 0 OID 0)
-- Dependencies: 188
-- Name: mail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_id_seq OWNED BY mail.id;


--
-- TOC entry 189 (class 1259 OID 12643942)
-- Dependencies: 6
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
-- TOC entry 190 (class 1259 OID 12643945)
-- Dependencies: 6 189
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
-- TOC entry 2210 (class 0 OID 0)
-- Dependencies: 190
-- Name: mail_tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_tickets_id_seq OWNED BY mail_ticket.id;


SET default_with_oids = true;

--
-- TOC entry 191 (class 1259 OID 12643947)
-- Dependencies: 6
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
-- TOC entry 192 (class 1259 OID 12643950)
-- Dependencies: 6 191
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
-- TOC entry 2211 (class 0 OID 0)
-- Dependencies: 192
-- Name: mail_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_user_id_seq OWNED BY mail_user.id;


--
-- TOC entry 193 (class 1259 OID 12643952)
-- Dependencies: 6
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
-- TOC entry 2212 (class 0 OID 0)
-- Dependencies: 193
-- Name: TABLE speech; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE speech IS 'respuestas rapidas predeterminadas';


--
-- TOC entry 194 (class 1259 OID 12643955)
-- Dependencies: 193 6
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
-- TOC entry 2213 (class 0 OID 0)
-- Dependencies: 194
-- Name: respuesta_rapida_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE respuesta_rapida_id_seq OWNED BY speech.id;


SET default_with_oids = false;

--
-- TOC entry 195 (class 1259 OID 12643962)
-- Dependencies: 6
-- Name: status; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE status (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    color character varying(50)
);


ALTER TABLE public.status OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 12643965)
-- Dependencies: 6 195
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
-- TOC entry 2214 (class 0 OID 0)
-- Dependencies: 196
-- Name: statu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE statu_id_seq OWNED BY status.id;


--
-- TOC entry 197 (class 1259 OID 12643967)
-- Dependencies: 6
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
-- TOC entry 198 (class 1259 OID 12643970)
-- Dependencies: 6 197
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
-- TOC entry 2215 (class 0 OID 0)
-- Dependencies: 198
-- Name: tested_numbers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tested_numbers_id_seq OWNED BY tested_number.id;


--
-- TOC entry 199 (class 1259 OID 12643972)
-- Dependencies: 6
-- Name: ticket; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ticket (
    id integer NOT NULL,
    id_failure integer NOT NULL,
    id_status integer NOT NULL,
    origination_ip character varying(64) NOT NULL,
    destination_ip character varying(64) NOT NULL,
    date date NOT NULL,
    machine_ip character varying(64) NOT NULL,
    hour time without time zone,
    id_gmt integer,
    ticket_number character varying(50),
    prefix integer,
    id_user integer
);


ALTER TABLE public.ticket OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 200 (class 1259 OID 12643975)
-- Dependencies: 6
-- Name: ticket_relation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ticket_relation (
    id integer NOT NULL,
    id_ticket_father integer NOT NULL,
    id_ticket_son integer NOT NULL
);


ALTER TABLE public.ticket_relation OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 12643978)
-- Dependencies: 6 200
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
-- TOC entry 2216 (class 0 OID 0)
-- Dependencies: 201
-- Name: ticket_relation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ticket_relation_id_seq OWNED BY ticket_relation.id;


--
-- TOC entry 202 (class 1259 OID 12643980)
-- Dependencies: 199 6
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
-- TOC entry 2217 (class 0 OID 0)
-- Dependencies: 202
-- Name: tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tickets_id_seq OWNED BY ticket.id;


SET default_with_oids = false;

--
-- TOC entry 206 (class 1259 OID 13313947)
-- Dependencies: 6
-- Name: type_mailing; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE type_mailing (
    id integer NOT NULL,
    name character varying(50)
);


ALTER TABLE public.type_mailing OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 13313945)
-- Dependencies: 206 6
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
-- TOC entry 2218 (class 0 OID 0)
-- Dependencies: 205
-- Name: type_mailing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE type_mailing_id_seq OWNED BY type_mailing.id;


--
-- TOC entry 1968 (class 2604 OID 12643987)
-- Dependencies: 165 164
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY class ALTER COLUMN id SET DEFAULT nextval('clase_id_seq'::regclass);


--
-- TOC entry 1969 (class 2604 OID 12643988)
-- Dependencies: 182 166
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('destinos_id_seq'::regclass);


--
-- TOC entry 1976 (class 2604 OID 12643989)
-- Dependencies: 171 170
-- Name: idfield; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_field ALTER COLUMN idfield SET DEFAULT nextval('cruge_field_idfield_seq'::regclass);


--
-- TOC entry 1977 (class 2604 OID 12643990)
-- Dependencies: 173 172
-- Name: idfieldvalue; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue ALTER COLUMN idfieldvalue SET DEFAULT nextval('cruge_fieldvalue_idfieldvalue_seq'::regclass);


--
-- TOC entry 1980 (class 2604 OID 12643991)
-- Dependencies: 175 174
-- Name: idsession; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_session ALTER COLUMN idsession SET DEFAULT nextval('cruge_session_idsession_seq'::regclass);


--
-- TOC entry 1992 (class 2604 OID 12643992)
-- Dependencies: 177 176
-- Name: idsystem; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_system ALTER COLUMN idsystem SET DEFAULT nextval('cruge_system_idsystem_seq'::regclass);


--
-- TOC entry 1996 (class 2604 OID 12643993)
-- Dependencies: 179 178
-- Name: iduser; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_user ALTER COLUMN iduser SET DEFAULT nextval('cruge_user_iduser_seq'::regclass);


--
-- TOC entry 1997 (class 2604 OID 12643994)
-- Dependencies: 181 180
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket ALTER COLUMN id SET DEFAULT nextval('descripcion_ticket_id_seq'::regclass);


--
-- TOC entry 2001 (class 2604 OID 12643995)
-- Dependencies: 184 183
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY failure ALTER COLUMN id SET DEFAULT nextval('fallas_id_seq'::regclass);


--
-- TOC entry 1967 (class 2604 OID 12643996)
-- Dependencies: 163 162
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file ALTER COLUMN id SET DEFAULT nextval('archivos_id_seq'::regclass);


--
-- TOC entry 2002 (class 2604 OID 12643997)
-- Dependencies: 186 185
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY gmt ALTER COLUMN id SET DEFAULT nextval('gmt_id_seq'::regclass);


--
-- TOC entry 2011 (class 2604 OID 12645885)
-- Dependencies: 204 203 204
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY language ALTER COLUMN id SET DEFAULT nextval('language_id_seq'::regclass);


--
-- TOC entry 2003 (class 2604 OID 12643998)
-- Dependencies: 188 187
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail ALTER COLUMN id SET DEFAULT nextval('mail_id_seq'::regclass);


--
-- TOC entry 2004 (class 2604 OID 12643999)
-- Dependencies: 190 189
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket ALTER COLUMN id SET DEFAULT nextval('mail_tickets_id_seq'::regclass);


--
-- TOC entry 2005 (class 2604 OID 12644000)
-- Dependencies: 192 191
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user ALTER COLUMN id SET DEFAULT nextval('mail_user_id_seq'::regclass);


--
-- TOC entry 2006 (class 2604 OID 12644001)
-- Dependencies: 194 193
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speech ALTER COLUMN id SET DEFAULT nextval('respuesta_rapida_id_seq'::regclass);


--
-- TOC entry 2007 (class 2604 OID 12644002)
-- Dependencies: 196 195
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY status ALTER COLUMN id SET DEFAULT nextval('statu_id_seq'::regclass);


--
-- TOC entry 2008 (class 2604 OID 12644003)
-- Dependencies: 198 197
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number ALTER COLUMN id SET DEFAULT nextval('tested_numbers_id_seq'::regclass);


--
-- TOC entry 2009 (class 2604 OID 12644004)
-- Dependencies: 202 199
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket ALTER COLUMN id SET DEFAULT nextval('tickets_id_seq'::regclass);


--
-- TOC entry 2010 (class 2604 OID 12644005)
-- Dependencies: 201 200
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation ALTER COLUMN id SET DEFAULT nextval('ticket_relation_id_seq'::regclass);


--
-- TOC entry 2012 (class 2604 OID 13313950)
-- Dependencies: 206 205 206
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY type_mailing ALTER COLUMN id SET DEFAULT nextval('type_mailing_id_seq'::regclass);


--
-- TOC entry 2016 (class 2606 OID 13283314)
-- Dependencies: 164 164 2189
-- Name: class_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY class
    ADD CONSTRAINT class_pk PRIMARY KEY (id);


--
-- TOC entry 2018 (class 2606 OID 12644139)
-- Dependencies: 166 166 2189
-- Name: country_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pk PRIMARY KEY (id);


--
-- TOC entry 2020 (class 2606 OID 12644141)
-- Dependencies: 167 167 167 2189
-- Name: cruge_authassignment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT cruge_authassignment_pkey PRIMARY KEY (userid, itemname);


--
-- TOC entry 2022 (class 2606 OID 12644143)
-- Dependencies: 168 168 2189
-- Name: cruge_authitem_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authitem
    ADD CONSTRAINT cruge_authitem_pkey PRIMARY KEY (name);


--
-- TOC entry 2024 (class 2606 OID 12644145)
-- Dependencies: 169 169 169 2189
-- Name: cruge_authitemchild_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT cruge_authitemchild_pkey PRIMARY KEY (parent, child);


--
-- TOC entry 2026 (class 2606 OID 12644147)
-- Dependencies: 170 170 2189
-- Name: cruge_field_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_field
    ADD CONSTRAINT cruge_field_pkey PRIMARY KEY (idfield);


--
-- TOC entry 2028 (class 2606 OID 12644149)
-- Dependencies: 172 172 2189
-- Name: cruge_fieldvalue_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT cruge_fieldvalue_pkey PRIMARY KEY (idfieldvalue);


--
-- TOC entry 2030 (class 2606 OID 12644151)
-- Dependencies: 174 174 2189
-- Name: cruge_session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_session
    ADD CONSTRAINT cruge_session_pkey PRIMARY KEY (idsession);


--
-- TOC entry 2032 (class 2606 OID 12644153)
-- Dependencies: 176 176 2189
-- Name: cruge_system_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_system
    ADD CONSTRAINT cruge_system_pkey PRIMARY KEY (idsystem);


--
-- TOC entry 2034 (class 2606 OID 12644155)
-- Dependencies: 178 178 2189
-- Name: cruge_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_user
    ADD CONSTRAINT cruge_user_pkey PRIMARY KEY (iduser);


--
-- TOC entry 2036 (class 2606 OID 12644157)
-- Dependencies: 180 180 2189
-- Name: description_ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT description_ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2038 (class 2606 OID 12644159)
-- Dependencies: 183 183 2189
-- Name: failure_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY failure
    ADD CONSTRAINT failure_pk PRIMARY KEY (id);


--
-- TOC entry 2014 (class 2606 OID 12644161)
-- Dependencies: 162 162 2189
-- Name: file_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY file
    ADD CONSTRAINT file_pk PRIMARY KEY (id);


--
-- TOC entry 2040 (class 2606 OID 12644163)
-- Dependencies: 185 185 2189
-- Name: gmt_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY gmt
    ADD CONSTRAINT gmt_pk PRIMARY KEY (id);


--
-- TOC entry 2062 (class 2606 OID 13313952)
-- Dependencies: 206 206 2189
-- Name: id_type_mailing; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY type_mailing
    ADD CONSTRAINT id_type_mailing PRIMARY KEY (id);


--
-- TOC entry 2060 (class 2606 OID 12645887)
-- Dependencies: 204 204 2189
-- Name: language_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY language
    ADD CONSTRAINT language_pk PRIMARY KEY (id);


--
-- TOC entry 2042 (class 2606 OID 12644167)
-- Dependencies: 187 187 2189
-- Name: mail_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail
    ADD CONSTRAINT mail_pk PRIMARY KEY (id);


--
-- TOC entry 2046 (class 2606 OID 12644169)
-- Dependencies: 189 189 2189
-- Name: mail_ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT mail_ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2044 (class 2606 OID 12644171)
-- Dependencies: 187 187 2189
-- Name: mail_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail
    ADD CONSTRAINT mail_unique UNIQUE (mail);


--
-- TOC entry 2048 (class 2606 OID 12644173)
-- Dependencies: 191 191 2189
-- Name: mail_user_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT mail_user_pk PRIMARY KEY (id);


--
-- TOC entry 2058 (class 2606 OID 12644175)
-- Dependencies: 200 200 2189
-- Name: pk_ticket_relation; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT pk_ticket_relation PRIMARY KEY (id);


--
-- TOC entry 2050 (class 2606 OID 12644177)
-- Dependencies: 193 193 2189
-- Name: speech_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speech
    ADD CONSTRAINT speech_pk PRIMARY KEY (id);


--
-- TOC entry 2052 (class 2606 OID 12644179)
-- Dependencies: 195 195 2189
-- Name: status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT status_pk PRIMARY KEY (id);


--
-- TOC entry 2054 (class 2606 OID 12644181)
-- Dependencies: 197 197 2189
-- Name: tested_number_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT tested_number_pk PRIMARY KEY (id);


--
-- TOC entry 2056 (class 2606 OID 12644183)
-- Dependencies: 199 199 2189
-- Name: ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2080 (class 2606 OID 12644188)
-- Dependencies: 2017 166 197 2189
-- Name: country_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT country_fk FOREIGN KEY (id_country) REFERENCES country(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2071 (class 2606 OID 16711043)
-- Dependencies: 180 2033 178 2189
-- Name: cruge_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT cruge_user_fk FOREIGN KEY (id_user) REFERENCES cruge_user(iduser);


--
-- TOC entry 2067 (class 2606 OID 12644198)
-- Dependencies: 169 2021 168 2189
-- Name: crugeauthitemchild_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT crugeauthitemchild_ibfk_1 FOREIGN KEY (parent) REFERENCES cruge_authitem(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2068 (class 2606 OID 12644203)
-- Dependencies: 169 2021 168 2189
-- Name: crugeauthitemchild_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT crugeauthitemchild_ibfk_2 FOREIGN KEY (child) REFERENCES cruge_authitem(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2064 (class 2606 OID 13313920)
-- Dependencies: 2035 162 180 2189
-- Name: description_ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file
    ADD CONSTRAINT description_ticket_fk FOREIGN KEY (id_description_ticket) REFERENCES description_ticket(id);


--
-- TOC entry 2082 (class 2606 OID 13313990)
-- Dependencies: 2037 183 199 2189
-- Name: failure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT failure_fk FOREIGN KEY (id_failure) REFERENCES failure(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2065 (class 2606 OID 12644213)
-- Dependencies: 168 167 2021 2189
-- Name: fk_cruge_authassignment_cruge_authitem1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT fk_cruge_authassignment_cruge_authitem1 FOREIGN KEY (itemname) REFERENCES cruge_authitem(name);


--
-- TOC entry 2066 (class 2606 OID 12644218)
-- Dependencies: 2033 167 178 2189
-- Name: fk_cruge_authassignment_user; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT fk_cruge_authassignment_user FOREIGN KEY (userid) REFERENCES cruge_user(iduser) ON DELETE CASCADE;


--
-- TOC entry 2069 (class 2606 OID 12644223)
-- Dependencies: 170 172 2025 2189
-- Name: fk_cruge_fieldvalue_cruge_field1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT fk_cruge_fieldvalue_cruge_field1 FOREIGN KEY (idfield) REFERENCES cruge_field(idfield) ON DELETE CASCADE;


--
-- TOC entry 2070 (class 2606 OID 12644228)
-- Dependencies: 172 178 2033 2189
-- Name: fk_cruge_fieldvalue_cruge_user1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT fk_cruge_fieldvalue_cruge_user1 FOREIGN KEY (iduser) REFERENCES cruge_user(iduser) ON DELETE CASCADE;


--
-- TOC entry 2085 (class 2606 OID 12644233)
-- Dependencies: 199 2055 200 2189
-- Name: fk_ticket_id_ticket_pather; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT fk_ticket_id_ticket_pather FOREIGN KEY (id_ticket_father) REFERENCES ticket(id);


--
-- TOC entry 2086 (class 2606 OID 12644238)
-- Dependencies: 2055 200 199 2189
-- Name: fk_ticket_id_ticket_son; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT fk_ticket_id_ticket_son FOREIGN KEY (id_ticket_son) REFERENCES ticket(id);


--
-- TOC entry 2083 (class 2606 OID 13313995)
-- Dependencies: 185 199 2039 2189
-- Name: gmt_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT gmt_fk FOREIGN KEY (id_gmt) REFERENCES gmt(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2079 (class 2606 OID 12645896)
-- Dependencies: 204 193 2059 2189
-- Name: language_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speech
    ADD CONSTRAINT language_fk FOREIGN KEY (id_language) REFERENCES language(id);


--
-- TOC entry 2077 (class 2606 OID 13313980)
-- Dependencies: 191 2041 187 2189
-- Name: mail_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT mail_fk FOREIGN KEY (id_mail) REFERENCES mail(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2074 (class 2606 OID 13313955)
-- Dependencies: 189 2047 191 2189
-- Name: mail_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT mail_user_fk FOREIGN KEY (id_mail_user) REFERENCES mail_user(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2072 (class 2606 OID 16711048)
-- Dependencies: 2049 180 193 2189
-- Name: speech_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT speech_fk FOREIGN KEY (id_speech) REFERENCES speech(id);


--
-- TOC entry 2084 (class 2606 OID 13314000)
-- Dependencies: 195 199 2051 2189
-- Name: status_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT status_fk FOREIGN KEY (id_status) REFERENCES status(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2081 (class 2606 OID 12644273)
-- Dependencies: 2055 199 197 2189
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2063 (class 2606 OID 13313915)
-- Dependencies: 2055 199 162 2189
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2075 (class 2606 OID 13313960)
-- Dependencies: 199 189 2055 2189
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2073 (class 2606 OID 16711053)
-- Dependencies: 180 2055 199 2189
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2076 (class 2606 OID 13313965)
-- Dependencies: 2061 206 189 2189
-- Name: type_mailing_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT type_mailing_fk FOREIGN KEY (id_type_mailing) REFERENCES type_mailing(id);


--
-- TOC entry 2078 (class 2606 OID 13313985)
-- Dependencies: 2033 191 178 2189
-- Name: user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT user_fk FOREIGN KEY (id_user) REFERENCES cruge_user(iduser);


--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-03-21 18:26:36 VET

--
-- PostgreSQL database dump complete
--

