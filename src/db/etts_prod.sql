--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.9
-- Dumped by pg_dump version 9.1.12
-- Started on 2014-03-21 18:47:13 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 211 (class 3079 OID 11677)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2216 (class 0 OID 0)
-- Dependencies: 211
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 212 (class 3079 OID 4061844)
-- Dependencies: 6
-- Name: dblink; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS dblink WITH SCHEMA public;


--
-- TOC entry 2217 (class 0 OID 0)
-- Dependencies: 212
-- Name: EXTENSION dblink; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION dblink IS 'connect to other PostgreSQL databases from within a database';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 162 (class 1259 OID 4061895)
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
-- TOC entry 163 (class 1259 OID 4061898)
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
-- TOC entry 2218 (class 0 OID 0)
-- Dependencies: 163
-- Name: archivos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE archivos_id_seq OWNED BY file.id;


--
-- TOC entry 164 (class 1259 OID 4061901)
-- Dependencies: 6
-- Name: class; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE class (
    id integer NOT NULL,
    name character varying(40) NOT NULL
);


ALTER TABLE public.class OWNER TO postgres;

--
-- TOC entry 165 (class 1259 OID 4061904)
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
-- TOC entry 2219 (class 0 OID 0)
-- Dependencies: 165
-- Name: clase_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE clase_id_seq OWNED BY class.id;


--
-- TOC entry 166 (class 1259 OID 4061907)
-- Dependencies: 6
-- Name: country; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE country (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.country OWNER TO postgres;

--
-- TOC entry 167 (class 1259 OID 4061910)
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
-- TOC entry 168 (class 1259 OID 4061916)
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
-- TOC entry 169 (class 1259 OID 4061923)
-- Dependencies: 6
-- Name: cruge_authitemchild; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cruge_authitemchild (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE public.cruge_authitemchild OWNER TO postgres;

--
-- TOC entry 170 (class 1259 OID 4061926)
-- Dependencies: 1982 1983 1984 1985 1986 1987 6
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
-- TOC entry 171 (class 1259 OID 4061938)
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
-- TOC entry 2220 (class 0 OID 0)
-- Dependencies: 171
-- Name: cruge_field_idfield_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_field_idfield_seq OWNED BY cruge_field.idfield;


--
-- TOC entry 172 (class 1259 OID 4061941)
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
-- TOC entry 173 (class 1259 OID 4061947)
-- Dependencies: 172 6
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
-- TOC entry 2221 (class 0 OID 0)
-- Dependencies: 173
-- Name: cruge_fieldvalue_idfieldvalue_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_fieldvalue_idfieldvalue_seq OWNED BY cruge_fieldvalue.idfieldvalue;


--
-- TOC entry 174 (class 1259 OID 4061950)
-- Dependencies: 1990 1991 6
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
-- TOC entry 175 (class 1259 OID 4061955)
-- Dependencies: 174 6
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
-- TOC entry 2222 (class 0 OID 0)
-- Dependencies: 175
-- Name: cruge_session_idsession_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_session_idsession_seq OWNED BY cruge_session.idsession;


--
-- TOC entry 176 (class 1259 OID 4061957)
-- Dependencies: 1993 1994 1995 1996 1997 1998 1999 2000 2001 2002 2003 6
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
-- TOC entry 177 (class 1259 OID 4061974)
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
-- TOC entry 2223 (class 0 OID 0)
-- Dependencies: 177
-- Name: cruge_system_idsystem_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_system_idsystem_seq OWNED BY cruge_system.idsystem;


--
-- TOC entry 178 (class 1259 OID 4061977)
-- Dependencies: 2005 2006 2007 6
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
-- TOC entry 179 (class 1259 OID 4061983)
-- Dependencies: 6 178
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
-- TOC entry 2224 (class 0 OID 0)
-- Dependencies: 179
-- Name: cruge_user_iduser_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cruge_user_iduser_seq OWNED BY cruge_user.iduser;


--
-- TOC entry 180 (class 1259 OID 4061985)
-- Dependencies: 2010 2011 2012 6
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
-- TOC entry 181 (class 1259 OID 4061992)
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
-- TOC entry 2225 (class 0 OID 0)
-- Dependencies: 181
-- Name: descripcion_ticket_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE descripcion_ticket_id_seq OWNED BY description_ticket.id;


--
-- TOC entry 182 (class 1259 OID 4061994)
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
-- TOC entry 2226 (class 0 OID 0)
-- Dependencies: 182
-- Name: destinos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE destinos_id_seq OWNED BY country.id;


--
-- TOC entry 183 (class 1259 OID 4061996)
-- Dependencies: 6
-- Name: failure; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE failure (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.failure OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 4061999)
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
-- TOC entry 2227 (class 0 OID 0)
-- Dependencies: 184
-- Name: fallas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE fallas_id_seq OWNED BY failure.id;


SET default_with_oids = true;

--
-- TOC entry 185 (class 1259 OID 4062002)
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
-- TOC entry 186 (class 1259 OID 4062005)
-- Dependencies: 185 6
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
-- TOC entry 2228 (class 0 OID 0)
-- Dependencies: 186
-- Name: gmt_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE gmt_id_seq OWNED BY gmt.id;


SET default_with_oids = false;

--
-- TOC entry 206 (class 1259 OID 12645944)
-- Dependencies: 6
-- Name: language; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE language (
    id integer NOT NULL,
    name character varying(50) NOT NULL
);


ALTER TABLE public.language OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 12645942)
-- Dependencies: 6 206
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
-- TOC entry 2229 (class 0 OID 0)
-- Dependencies: 205
-- Name: language_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE language_id_seq OWNED BY language.id;


--
-- TOC entry 187 (class 1259 OID 4062008)
-- Dependencies: 6
-- Name: mail; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mail (
    id integer NOT NULL,
    mail character varying(100) NOT NULL
);


ALTER TABLE public.mail OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 4062011)
-- Dependencies: 187 6
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
-- TOC entry 2230 (class 0 OID 0)
-- Dependencies: 188
-- Name: mail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_id_seq OWNED BY mail.id;


SET default_with_oids = true;

--
-- TOC entry 202 (class 1259 OID 9286452)
-- Dependencies: 6
-- Name: mail_ticket; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mail_ticket (
    id integer NOT NULL,
    id_mail_user integer NOT NULL,
    id_ticket integer NOT NULL,
    id_type_mailing integer NOT NULL
);


ALTER TABLE public.mail_ticket OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 9286450)
-- Dependencies: 6 202
-- Name: mail_ticket_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mail_ticket_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mail_ticket_id_seq OWNER TO postgres;

--
-- TOC entry 2231 (class 0 OID 0)
-- Dependencies: 201
-- Name: mail_ticket_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_ticket_id_seq OWNED BY mail_ticket.id;


--
-- TOC entry 189 (class 1259 OID 4062019)
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
-- TOC entry 190 (class 1259 OID 4062022)
-- Dependencies: 189 6
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
-- TOC entry 2232 (class 0 OID 0)
-- Dependencies: 190
-- Name: mail_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE mail_user_id_seq OWNED BY mail_user.id;


--
-- TOC entry 207 (class 1259 OID 12645950)
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
-- TOC entry 2233 (class 0 OID 0)
-- Dependencies: 207
-- Name: TABLE speech; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE speech IS 'respuestas rapidas predeterminadas';


--
-- TOC entry 208 (class 1259 OID 12645956)
-- Dependencies: 6 207
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
-- TOC entry 2234 (class 0 OID 0)
-- Dependencies: 208
-- Name: respuesta_rapida_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE respuesta_rapida_id_seq OWNED BY speech.id;


SET default_with_oids = false;

--
-- TOC entry 191 (class 1259 OID 4062032)
-- Dependencies: 6
-- Name: type_of_user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE type_of_user (
    id integer NOT NULL,
    name character varying(40) NOT NULL
);


ALTER TABLE public.type_of_user OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 4062036)
-- Dependencies: 6 191
-- Name: rol_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE rol_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rol_id_seq OWNER TO postgres;

--
-- TOC entry 2235 (class 0 OID 0)
-- Dependencies: 192
-- Name: rol_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE rol_id_seq OWNED BY type_of_user.id;


--
-- TOC entry 193 (class 1259 OID 4062038)
-- Dependencies: 6
-- Name: status; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE status (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.status OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 4062041)
-- Dependencies: 6 193
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
-- TOC entry 2236 (class 0 OID 0)
-- Dependencies: 194
-- Name: statu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE statu_id_seq OWNED BY status.id;


--
-- TOC entry 195 (class 1259 OID 4062043)
-- Dependencies: 6
-- Name: tested_number; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tested_number (
    id integer NOT NULL,
    id_ticket integer NOT NULL,
    id_country integer NOT NULL,
    date date NOT NULL,
    hour time without time zone NOT NULL,
    numero character varying(25) NOT NULL
);


ALTER TABLE public.tested_number OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 4062047)
-- Dependencies: 195 6
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
-- TOC entry 2237 (class 0 OID 0)
-- Dependencies: 196
-- Name: tested_numbers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tested_numbers_id_seq OWNED BY tested_number.id;


--
-- TOC entry 197 (class 1259 OID 4062049)
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
    prefix character varying(25) NOT NULL,
    id_user integer
);


ALTER TABLE public.ticket OWNER TO postgres;

SET default_with_oids = true;

--
-- TOC entry 204 (class 1259 OID 9288172)
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
-- TOC entry 203 (class 1259 OID 9288170)
-- Dependencies: 204 6
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
-- TOC entry 2238 (class 0 OID 0)
-- Dependencies: 203
-- Name: ticket_relation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ticket_relation_id_seq OWNED BY ticket_relation.id;


--
-- TOC entry 198 (class 1259 OID 4062052)
-- Dependencies: 197 6
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
-- TOC entry 2239 (class 0 OID 0)
-- Dependencies: 198
-- Name: tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tickets_id_seq OWNED BY ticket.id;


SET default_with_oids = false;

--
-- TOC entry 210 (class 1259 OID 13316726)
-- Dependencies: 6
-- Name: type_mailing; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE type_mailing (
    id integer NOT NULL,
    name character varying(50)
);


ALTER TABLE public.type_mailing OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 13316724)
-- Dependencies: 6 210
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
-- TOC entry 2240 (class 0 OID 0)
-- Dependencies: 209
-- Name: type_mailing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE type_mailing_id_seq OWNED BY type_mailing.id;


--
-- TOC entry 199 (class 1259 OID 4062055)
-- Dependencies: 6
-- Name: user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "user" (
    id integer NOT NULL,
    id_type_of_user integer NOT NULL,
    username character varying(40) NOT NULL,
    password character varying(64) NOT NULL,
    estatus integer NOT NULL
);


ALTER TABLE public."user" OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 4062058)
-- Dependencies: 199 6
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id_seq OWNER TO postgres;

--
-- TOC entry 2241 (class 0 OID 0)
-- Dependencies: 200
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_id_seq OWNED BY "user".id;


--
-- TOC entry 1980 (class 2604 OID 4062061)
-- Dependencies: 165 164
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY class ALTER COLUMN id SET DEFAULT nextval('clase_id_seq'::regclass);


--
-- TOC entry 1981 (class 2604 OID 4062063)
-- Dependencies: 182 166
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('destinos_id_seq'::regclass);


--
-- TOC entry 1988 (class 2604 OID 4062064)
-- Dependencies: 171 170
-- Name: idfield; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_field ALTER COLUMN idfield SET DEFAULT nextval('cruge_field_idfield_seq'::regclass);


--
-- TOC entry 1989 (class 2604 OID 4062065)
-- Dependencies: 173 172
-- Name: idfieldvalue; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue ALTER COLUMN idfieldvalue SET DEFAULT nextval('cruge_fieldvalue_idfieldvalue_seq'::regclass);


--
-- TOC entry 1992 (class 2604 OID 4062066)
-- Dependencies: 175 174
-- Name: idsession; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_session ALTER COLUMN idsession SET DEFAULT nextval('cruge_session_idsession_seq'::regclass);


--
-- TOC entry 2004 (class 2604 OID 4062067)
-- Dependencies: 177 176
-- Name: idsystem; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_system ALTER COLUMN idsystem SET DEFAULT nextval('cruge_system_idsystem_seq'::regclass);


--
-- TOC entry 2008 (class 2604 OID 4062069)
-- Dependencies: 179 178
-- Name: iduser; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_user ALTER COLUMN iduser SET DEFAULT nextval('cruge_user_iduser_seq'::regclass);


--
-- TOC entry 2009 (class 2604 OID 4062070)
-- Dependencies: 181 180
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket ALTER COLUMN id SET DEFAULT nextval('descripcion_ticket_id_seq'::regclass);


--
-- TOC entry 2013 (class 2604 OID 4062071)
-- Dependencies: 184 183
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY failure ALTER COLUMN id SET DEFAULT nextval('fallas_id_seq'::regclass);


--
-- TOC entry 1979 (class 2604 OID 4062072)
-- Dependencies: 163 162
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file ALTER COLUMN id SET DEFAULT nextval('archivos_id_seq'::regclass);


--
-- TOC entry 2014 (class 2604 OID 4062073)
-- Dependencies: 186 185
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY gmt ALTER COLUMN id SET DEFAULT nextval('gmt_id_seq'::regclass);


--
-- TOC entry 2024 (class 2604 OID 12645947)
-- Dependencies: 206 205 206
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY language ALTER COLUMN id SET DEFAULT nextval('language_id_seq'::regclass);


--
-- TOC entry 2015 (class 2604 OID 4062075)
-- Dependencies: 188 187
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail ALTER COLUMN id SET DEFAULT nextval('mail_id_seq'::regclass);


--
-- TOC entry 2022 (class 2604 OID 9286455)
-- Dependencies: 202 201 202
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket ALTER COLUMN id SET DEFAULT nextval('mail_ticket_id_seq'::regclass);


--
-- TOC entry 2016 (class 2604 OID 4062077)
-- Dependencies: 190 189
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user ALTER COLUMN id SET DEFAULT nextval('mail_user_id_seq'::regclass);


--
-- TOC entry 2025 (class 2604 OID 12645958)
-- Dependencies: 208 207
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speech ALTER COLUMN id SET DEFAULT nextval('respuesta_rapida_id_seq'::regclass);


--
-- TOC entry 2018 (class 2604 OID 4062079)
-- Dependencies: 194 193
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY status ALTER COLUMN id SET DEFAULT nextval('statu_id_seq'::regclass);


--
-- TOC entry 2019 (class 2604 OID 4062080)
-- Dependencies: 196 195
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number ALTER COLUMN id SET DEFAULT nextval('tested_numbers_id_seq'::regclass);


--
-- TOC entry 2020 (class 2604 OID 4062081)
-- Dependencies: 198 197
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket ALTER COLUMN id SET DEFAULT nextval('tickets_id_seq'::regclass);


--
-- TOC entry 2023 (class 2604 OID 9288175)
-- Dependencies: 204 203 204
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation ALTER COLUMN id SET DEFAULT nextval('ticket_relation_id_seq'::regclass);


--
-- TOC entry 2026 (class 2604 OID 13316729)
-- Dependencies: 209 210 210
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY type_mailing ALTER COLUMN id SET DEFAULT nextval('type_mailing_id_seq'::regclass);


--
-- TOC entry 2017 (class 2604 OID 4062082)
-- Dependencies: 192 191
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY type_of_user ALTER COLUMN id SET DEFAULT nextval('rol_id_seq'::regclass);


--
-- TOC entry 2021 (class 2604 OID 4062084)
-- Dependencies: 200 199
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('usuarios_id_seq'::regclass);


--
-- TOC entry 2030 (class 2606 OID 4062214)
-- Dependencies: 164 164 2210
-- Name: class_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY class
    ADD CONSTRAINT class_pk PRIMARY KEY (id);


--
-- TOC entry 2032 (class 2606 OID 4062216)
-- Dependencies: 166 166 2210
-- Name: country_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pk PRIMARY KEY (id);


--
-- TOC entry 2034 (class 2606 OID 4062218)
-- Dependencies: 167 167 167 2210
-- Name: cruge_authassignment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT cruge_authassignment_pkey PRIMARY KEY (userid, itemname);


--
-- TOC entry 2036 (class 2606 OID 4062221)
-- Dependencies: 168 168 2210
-- Name: cruge_authitem_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authitem
    ADD CONSTRAINT cruge_authitem_pkey PRIMARY KEY (name);


--
-- TOC entry 2038 (class 2606 OID 4062223)
-- Dependencies: 169 169 169 2210
-- Name: cruge_authitemchild_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT cruge_authitemchild_pkey PRIMARY KEY (parent, child);


--
-- TOC entry 2040 (class 2606 OID 4062225)
-- Dependencies: 170 170 2210
-- Name: cruge_field_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_field
    ADD CONSTRAINT cruge_field_pkey PRIMARY KEY (idfield);


--
-- TOC entry 2042 (class 2606 OID 4062227)
-- Dependencies: 172 172 2210
-- Name: cruge_fieldvalue_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT cruge_fieldvalue_pkey PRIMARY KEY (idfieldvalue);


--
-- TOC entry 2044 (class 2606 OID 4062230)
-- Dependencies: 174 174 2210
-- Name: cruge_session_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_session
    ADD CONSTRAINT cruge_session_pkey PRIMARY KEY (idsession);


--
-- TOC entry 2046 (class 2606 OID 4062232)
-- Dependencies: 176 176 2210
-- Name: cruge_system_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_system
    ADD CONSTRAINT cruge_system_pkey PRIMARY KEY (idsystem);


--
-- TOC entry 2048 (class 2606 OID 4062234)
-- Dependencies: 178 178 2210
-- Name: cruge_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cruge_user
    ADD CONSTRAINT cruge_user_pkey PRIMARY KEY (iduser);


--
-- TOC entry 2050 (class 2606 OID 4062236)
-- Dependencies: 180 180 2210
-- Name: description_ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT description_ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2052 (class 2606 OID 4062239)
-- Dependencies: 183 183 2210
-- Name: failure_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY failure
    ADD CONSTRAINT failure_pk PRIMARY KEY (id);


--
-- TOC entry 2028 (class 2606 OID 4062241)
-- Dependencies: 162 162 2210
-- Name: file_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY file
    ADD CONSTRAINT file_pk PRIMARY KEY (id);


--
-- TOC entry 2054 (class 2606 OID 4062243)
-- Dependencies: 185 185 2210
-- Name: gmt_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY gmt
    ADD CONSTRAINT gmt_pk PRIMARY KEY (id);


--
-- TOC entry 2082 (class 2606 OID 13316731)
-- Dependencies: 210 210 2210
-- Name: id_type_mailing; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY type_mailing
    ADD CONSTRAINT id_type_mailing PRIMARY KEY (id);


--
-- TOC entry 2062 (class 2606 OID 4062245)
-- Dependencies: 191 191 2210
-- Name: id_type_of_user; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY type_of_user
    ADD CONSTRAINT id_type_of_user PRIMARY KEY (id);


--
-- TOC entry 2078 (class 2606 OID 12645949)
-- Dependencies: 206 206 2210
-- Name: language_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY language
    ADD CONSTRAINT language_pk PRIMARY KEY (id);


--
-- TOC entry 2056 (class 2606 OID 4062247)
-- Dependencies: 187 187 2210
-- Name: mail_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail
    ADD CONSTRAINT mail_pk PRIMARY KEY (id);


--
-- TOC entry 2074 (class 2606 OID 9286457)
-- Dependencies: 202 202 2210
-- Name: mail_ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT mail_ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2058 (class 2606 OID 4062252)
-- Dependencies: 187 187 2210
-- Name: mail_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail
    ADD CONSTRAINT mail_unique UNIQUE (mail);


--
-- TOC entry 2060 (class 2606 OID 4062254)
-- Dependencies: 189 189 2210
-- Name: mail_user_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT mail_user_pk PRIMARY KEY (id);


--
-- TOC entry 2080 (class 2606 OID 12645971)
-- Dependencies: 207 207 2210
-- Name: speech_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY speech
    ADD CONSTRAINT speech_pk PRIMARY KEY (id);


--
-- TOC entry 2064 (class 2606 OID 4062258)
-- Dependencies: 193 193 2210
-- Name: status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT status_pk PRIMARY KEY (id);


--
-- TOC entry 2066 (class 2606 OID 4062260)
-- Dependencies: 195 195 2210
-- Name: tested_number_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT tested_number_pk PRIMARY KEY (id);


--
-- TOC entry 2068 (class 2606 OID 4062262)
-- Dependencies: 197 197 2210
-- Name: ticket_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT ticket_pk PRIMARY KEY (id);


--
-- TOC entry 2076 (class 2606 OID 9288177)
-- Dependencies: 204 204 2210
-- Name: ticket_relation_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT ticket_relation_pk PRIMARY KEY (id);


--
-- TOC entry 2070 (class 2606 OID 4062264)
-- Dependencies: 199 199 2210
-- Name: user_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pk PRIMARY KEY (id);


--
-- TOC entry 2072 (class 2606 OID 4062267)
-- Dependencies: 199 199 2210
-- Name: username_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT username_unique UNIQUE (username);


--
-- TOC entry 2096 (class 2606 OID 9286400)
-- Dependencies: 2031 195 166 2210
-- Name: country_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT country_fk FOREIGN KEY (id_country) REFERENCES country(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2091 (class 2606 OID 16770106)
-- Dependencies: 178 2047 180 2210
-- Name: cruge_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT cruge_user_fk FOREIGN KEY (id_user) REFERENCES cruge_user(iduser);


--
-- TOC entry 2087 (class 2606 OID 4062273)
-- Dependencies: 2035 168 169 2210
-- Name: crugeauthitemchild_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT crugeauthitemchild_ibfk_1 FOREIGN KEY (parent) REFERENCES cruge_authitem(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2088 (class 2606 OID 4062278)
-- Dependencies: 168 169 2035 2210
-- Name: crugeauthitemchild_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authitemchild
    ADD CONSTRAINT crugeauthitemchild_ibfk_2 FOREIGN KEY (child) REFERENCES cruge_authitem(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2084 (class 2606 OID 13316774)
-- Dependencies: 2049 180 162 2210
-- Name: description_ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file
    ADD CONSTRAINT description_ticket_fk FOREIGN KEY (id_description_ticket) REFERENCES description_ticket(id);


--
-- TOC entry 2098 (class 2606 OID 13316824)
-- Dependencies: 197 2051 183 2210
-- Name: failure_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT failure_fk FOREIGN KEY (id_failure) REFERENCES failure(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2085 (class 2606 OID 4062288)
-- Dependencies: 168 167 2035 2210
-- Name: fk_cruge_authassignment_cruge_authitem1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT fk_cruge_authassignment_cruge_authitem1 FOREIGN KEY (itemname) REFERENCES cruge_authitem(name);


--
-- TOC entry 2086 (class 2606 OID 4062293)
-- Dependencies: 2047 167 178 2210
-- Name: fk_cruge_authassignment_user; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_authassignment
    ADD CONSTRAINT fk_cruge_authassignment_user FOREIGN KEY (userid) REFERENCES cruge_user(iduser) ON DELETE CASCADE;


--
-- TOC entry 2089 (class 2606 OID 4062298)
-- Dependencies: 172 170 2039 2210
-- Name: fk_cruge_fieldvalue_cruge_field1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT fk_cruge_fieldvalue_cruge_field1 FOREIGN KEY (idfield) REFERENCES cruge_field(idfield) ON DELETE CASCADE;


--
-- TOC entry 2090 (class 2606 OID 4062304)
-- Dependencies: 178 2047 172 2210
-- Name: fk_cruge_fieldvalue_cruge_user1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cruge_fieldvalue
    ADD CONSTRAINT fk_cruge_fieldvalue_cruge_user1 FOREIGN KEY (iduser) REFERENCES cruge_user(iduser) ON DELETE CASCADE;


--
-- TOC entry 2099 (class 2606 OID 13316829)
-- Dependencies: 197 2053 185 2210
-- Name: gmt_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT gmt_fk FOREIGN KEY (id_gmt) REFERENCES gmt(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2107 (class 2606 OID 12645972)
-- Dependencies: 2077 206 207 2210
-- Name: language_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY speech
    ADD CONSTRAINT language_fk FOREIGN KEY (id_language) REFERENCES language(id);


--
-- TOC entry 2094 (class 2606 OID 13316814)
-- Dependencies: 2055 189 187 2210
-- Name: mail_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT mail_fk FOREIGN KEY (id_mail) REFERENCES mail(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2102 (class 2606 OID 13316799)
-- Dependencies: 2059 202 189 2210
-- Name: mail_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT mail_user_fk FOREIGN KEY (id_mail_user) REFERENCES mail_user(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2092 (class 2606 OID 16770111)
-- Dependencies: 180 2079 207 2210
-- Name: speech_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT speech_fk FOREIGN KEY (id_speech) REFERENCES speech(id);


--
-- TOC entry 2100 (class 2606 OID 13316834)
-- Dependencies: 193 2063 197 2210
-- Name: status_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket
    ADD CONSTRAINT status_fk FOREIGN KEY (id_status) REFERENCES status(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2105 (class 2606 OID 9288178)
-- Dependencies: 197 2067 204 2210
-- Name: ticket_father_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT ticket_father_fk FOREIGN KEY (id_ticket_father) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2097 (class 2606 OID 9286405)
-- Dependencies: 195 2067 197 2210
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tested_number
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2083 (class 2606 OID 13316769)
-- Dependencies: 162 2067 197 2210
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY file
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2103 (class 2606 OID 13316804)
-- Dependencies: 197 202 2067 2210
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2093 (class 2606 OID 16770116)
-- Dependencies: 2067 180 197 2210
-- Name: ticket_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY description_ticket
    ADD CONSTRAINT ticket_fk FOREIGN KEY (id_ticket) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2106 (class 2606 OID 9288183)
-- Dependencies: 204 197 2067 2210
-- Name: ticket_son_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ticket_relation
    ADD CONSTRAINT ticket_son_fk FOREIGN KEY (id_ticket_son) REFERENCES ticket(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2104 (class 2606 OID 13316809)
-- Dependencies: 2081 210 202 2210
-- Name: type_mailing_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_ticket
    ADD CONSTRAINT type_mailing_fk FOREIGN KEY (id_type_mailing) REFERENCES type_mailing(id);


--
-- TOC entry 2101 (class 2606 OID 4062355)
-- Dependencies: 2061 199 191 2210
-- Name: type_of_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT type_of_user_fk FOREIGN KEY (id_type_of_user) REFERENCES type_of_user(id) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- TOC entry 2095 (class 2606 OID 13316819)
-- Dependencies: 2047 178 189 2210
-- Name: user_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY mail_user
    ADD CONSTRAINT user_fk FOREIGN KEY (id_user) REFERENCES cruge_user(iduser);


--
-- TOC entry 2215 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2014-03-21 18:47:27 VET

--
-- PostgreSQL database dump complete
--

