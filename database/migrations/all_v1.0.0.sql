BEGIN TRY
SET NOCOUNT ON;
PRINT '...DATABASE CONFIGURATION STARTS...'

    USE master;

    IF( DB_ID('escal') IS NOT NULL )
    BEGIN
        DROP DATABASE escal;
    END


    CREATE DATABASE escal COLLATE SQL_latin1_General_CP1_CS_AS;

PRINT '...DATABASE CONFIGURATION ENDS, NO ERRORS DETECTED...'
END TRY
BEGIN CATCH
    PRINT 'DATABASE CONFIGURATION STOPS, ERROR DETECTED'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
GO
PRINT ''
USE escal;
GO








BEGIN TRY
SET NOCOUNT ON;
PRINT '...TABLES CREATION STARTS...'

    CREATE TABLE personal_access_tokens(

        id                                          BIGINT                          PRIMARY KEY IDENTITY NOT NULL,
        tokenable_type                              NVARCHAR(255)                   NOT NULL,
        tokenable_id                                VARCHAR(50)                     NOT NULL,
        name                                        NVARCHAR(255)                   NOT NULL,
        token                                       NVARCHAR(64)                    NOT NULL,
        abilities                                   NVARCHAR(MAX)                   NULL,
        last_used_at                                DATETIME2                       NULL,
        expires_at                                  DATETIME2                       NULL,
        created_at                                  DATETIME2                       NULL,
        updated_at                                  DATETIME2                       NULL
        
    );

    CREATE TABLE versions(

        --Default Columns
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        
        --Data Columns
        version_number                              VARCHAR(20)                     PRIMARY KEY NOT NULL,
        version_title                               VARCHAR(50)                     NOT NULL,
        release_date                                DATETIME2                       NOT NULL
 
    );

    CREATE TABLE changelogs(

        --Default Columns
        RECORD_id                                   BIGINT                          NOT NULL PRIMARY KEY IDENTITY,         
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        
        --Foreign Key Columns
        FK_version_number                           VARCHAR(20)                     NOT NULL FOREIGN KEY REFERENCES versions(version_number),
        
        --Data Columns
        changelog_title                             VARCHAR(255)                    NOT NULL,              
        changelog_description                       TEXT                            NOT NULL

    );

    

    CREATE TABLE admins(

        --Default Columns
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        RECORD_deleted_at                           DATETIME2                       DEFAULT NULL,

        --Data Columns
        username                                    VARCHAR(50)                     NOT NULL PRIMARY KEY,
        pwd                                         VARCHAR(255)                    NOT NULL

    );

    CREATE TABLE courses(

        --Default Columns
        RECORD_id                                   BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        RECORD_deleted_at                           DATETIME2                       DEFAULT NULL,

        --Data Columns
        course_name                                 VARCHAR(255)                    NOT NULL

    );

    CREATE TABLE teachers(

        --Default Columns
        RECORD_id                                   BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        RECORD_deleted_at                           DATETIME2                       DEFAULT NULL,

        --Data Columns
        teacher_name                                VARCHAR(255)                    NOT NULL,
        photo_path                                  VARCHAR(255)                    DEFAULT NULL,
        worker_id                                   VARCHAR(12)                     DEFAULT NULL

    );

    CREATE TABLE survey_status(

        --Default Columns
        RECORD_id                                   TINYINT                         NOT NULL PRIMARY KEY IDENTITY,
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        RECORD_deleted_at                           DATETIME2                       DEFAULT NULL,

        --Data Columns
        survey_status_description                   VARCHAR(50)                     NOT NULL

    );

    CREATE TABLE surveys(

        --Default Columns
        RECORD_id                                   BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        RECORD_deleted_at                           DATETIME2                       DEFAULT NULL,

        --Foreign Key Columns
        FK_course_id                                BIGINT                          NOT NULL FOREIGN KEY REFERENCES courses(RECORD_id),
        FK_teacher_id                               BIGINT                          NOT NULL FOREIGN KEY REFERENCES teachers(RECORD_id),
        FK_survey_status_id                         TINYINT                         NOT NULL FOREIGN KEY REFERENCES survey_status(RECORD_id),

        --Data Columns
        course_starts_at                            DATETIME2                       NOT NULL,
        course_ends_at                              DATETIME2                       NOT NULL,
        teacher_code                                VARCHAR(4)                      NOT NULL

    );

    CREATE TABLE survey_questions(

        --Default Columns
        RECORD_id                                   BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        RECORD_deleted_at                           DATETIME2                       DEFAULT NULL,

        --Data Columns
        question_type                               BIT                             NOT NULL, --1 for teacher type, 0 for course type
        question_text                               VARCHAR(255)                    NOT NULL

    );

    CREATE TABLE survey_answers(

        --Default Columns
        RECORD_id                                   BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,
        RECORD_deleted_at                           DATETIME2                       DEFAULT NULL,

        --Foreign Key Columns
        FK_survey_id                                BIGINT                          NOT NULL FOREIGN KEY REFERENCES surveys(RECORD_id),

        --Data Columns
        student_code                                VARCHAR(4)                      NOT NULL,
        is_fulfilled                                BIT                             NOT NULL DEFAULT 0,
        comments                                    TEXT                            DEFAULT NULL

    );

    CREATE TABLE survey_question_survey_answer(

        --Default Columns
        RECORD_id                                   BIGINT                          NOT NULL PRIMARY KEY IDENTITY,
        RECORD_created_at                           DATETIME2                       DEFAULT GETDATE(),
        RECORD_updated_at                           DATETIME2                       DEFAULT NULL,

       --Foreign Key Columns
        FK_survey_answer_id                         BIGINT                          NOT NULL FOREIGN KEY REFERENCES survey_answers(RECORD_id),
        FK_survey_question_id                       BIGINT                          NOT NULL FOREIGN KEY REFERENCES survey_questions(RECORD_id),  

        --Data Columns
        answer_value                                TINYINT                         NOT NULL CHECK(0 <= answer_value AND answer_value <= 10) 

    );



PRINT '...TABLES CREATION ENDS, NO ERRORS DETECTED...'
END TRY
BEGIN CATCH
    PRINT 'TABLES CREATION STOPS, ERROR DETECTED'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
PRINT '';








BEGIN TRY
SET NOCOUNT ON;
PRINT '...DEFAULT DATA INSERTION STARTS...'

    INSERT INTO survey_status(survey_status_description) VALUES
        ('En espera'),
        ('Abierta'),
        ('Cerrada');


    INSERT INTO survey_questions(question_type, question_text) VALUES
        (1, 'La información que dio al grupo sobre los objetivos:'),
        (1, 'El conocimiento que demostró de los temas fue:'),
        (1, 'La claridad con que expuso fue:'),
        (1, 'Respondió a las dudas y preguntas surgidas durante la impartición del tema, en forma:'),
        (1, 'Propició un clima de colaboración en forma:'),
        (1, 'Aprovecho el material didáctico disponible en forma:'),
        (1, 'Aprovecho el tiempo programado para su exposición en forma:'),
        (1, 'Mantuvo el interés del grupo en forma:'),
        (1, 'Las actividades realizadas facilitaron el aprendizaje en forma:'),
        (1, 'Su labor de supervisión al trabajo de equipo fue:'),
        (0, 'Sus expectativas respecto al curso se vieron satisfechas en forma:'),
        (0, 'La capacitación tiene aplicación en su puesto, en forma:'),
        (0, 'El material didáctico apoyó el aprendizaje en forma:'),
        (0, 'Las actividades programadas se llevaron a cabo en forma:'),
        (0, 'La calidad de la coordinación del curso fue:'),
        (0, 'Los ejercicios y dinamicas grupales se relacionaron con el capacitación en forma:'),
        (0, 'El aula fue adecuada y cómoda en forma:'),
        (0, 'Los tramites y entrega de constancias fueron:'),
        (0, 'La iluminación, ventilación y sonido fueron:'),
        (0, 'Considera que los servicios adicionales fueron:');

PRINT '...DEFAULT DATA INSERTION ENDS, NO ERRORS DETECTED...'
END TRY
BEGIN CATCH
    PRINT 'DEFAULT DATA INSERTION STOPS, ERROR DETECTED'
    PRINT ERROR_MESSAGE();
    RETURN;
END CATCH
PRINT '';


